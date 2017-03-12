<?php 

namespace Packages\Cms\Services;

use Packages\Cms\Support\Abstracts\HookEvent;

class Action extends HookEvent
{
    /**
     * Filter a value
     * @param  string $action Name of action
     * @param  array $args Arguments passed to the filter
     * @author Tor Morten Jensen <tormorten@tormorten.no>
     */
    public function fire($action, array $args)
    {
        if ($this->getListeners()) {
            foreach ($this->getListeners() as $priority => $listeners) {
                foreach ($listeners as $hook => $arguments) {
                    if ($hook === $action) {
                        call_user_func_array($this->getFunction($arguments['callback']), $args);
                    }
                }
            }
        }
    }
}
