<?php 

namespace Phambinh\Cms\Services;

class Metatag
{
    /**
     * Store meta tags
     * @var array
     */
    protected $metas = [];

    /**
     * Các thông tin cấu hình
     * @var array
     */
    protected $config = [
        'title_delimit'    =>    ' | ',
    ];

    /**
     * Khởi chạy class
     * @param array $config [description]
     */
    public function __construct($config = [])
    {
        if (count($config) > 0) {
            $this->config = $config;
        }

        return $this;
    }

    /**
     * Set một thẻ meta mới
     * @param string  $key                Khóa của thẻ meta hoặc thuộc tính "name"
     * @param tring|array  $attributeOrContnet Các thuộc tính hoặc thuộc tính "content"
     * @param boolean $override           Cho phép ghi đè nội dung đã có hay không
     */
    public function set($key, $attributeOrContnet, $override = false)
    {
        $content = null;
        $attribute = [];
        $isAttribute = false;

        if (is_array($attributeOrContnet)) {
            $attribute = $attributeOrContnet;
            $isAttribute = true;
        } else {
            $content = $attributeOrContnet;
        }


        if (! $isAttribute) {
            $attribute['content'] = $content;
        }

        if (! isset($attribute['name']) && ! $isAttribute);
        $attribute['name'] = $key;

        $this->register($key, $attribute, $override);
    }

    /**
     * Đăng ký một thẻ meta
     * @param  string $key
     * @param  array $attribute
     * @param  boolean $override
     * @return void
     */
    private function register($key, $attribute, $override)
    {
        if (isset($this->metas[$key])) {
            if ($override) {
                $this->metas[$key] = array_merge($this->metas[$key], $attribute);
            } elseif ($key == 'title') {
                $title[] = $this->get('title.content');
                array_unshift($title, $attribute['content']);
                $this->metas['title']['content'] = implode($this->config['title_delimit'], $title);
            }
        } else {
            $this->metas[$key] = $attribute;
        }

        return $this;
    }

    /**
     * Lấy một thẻ meta
     * @param  string $str
     * @return array
     */
    public function get($str)
    {
        return array_get($this->metas, $str);
    }

    /**
     * Render các thẻ meta
     * @param  string $key
     * @return void
     */
    public function render($key = null)
    {
        if ($key) {
            return $this->build($key);
        }

        foreach ($this->metas as $metaKey => $attribute) {
            $this->build($metaKey);
        }
    }

    /**
     * Xây dựng hoàn chỉnh một thẻ meta và echo ra
     * @param  string $key
     * @param  array $attribute
     * @return void
     */
    private function build($key)
    {
        $attribute = $this->metas[$key];
        switch ($key) {
            case 'title':
                echo '<title>'. e($attribute['content']).'</title>'."\n";
                break;
            
            default:
                echo '<meta ' . $this->explandAttribute($attribute) .' />'."\n";
                break;
        }
    }

    /**
     * Viết các attribute dưới dạng thuộc tính html
     * @param  array $attribute
     * @return string
     */
    private function explandAttribute($attribute)
    {
        $string = null;
        foreach ($attribute as $key => $value) {
            $string .= e($key) .'="'. e($value) .'" ';
        }

        return trim($string);
    }
}
