<?php

use Illuminate\Database\Seeder;

class EcommerceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Packages\Ecommerce\Category::class, 5)->create();
        factory(Packages\Ecommerce\Brand::class, 5)->create();
        factory(Packages\Ecommerce\Filter::class, 5)->create();
        factory(Packages\Ecommerce\Tag::class, 15)->create();
        factory(Packages\Ecommerce\Attribute::class, 15)->create();

        factory(Packages\Ecommerce\Option::class, 5)->create()->each(function ($option) {
            if ($option->hasManyValues()) {
                $option->values()->saveMany(factory(Packages\Ecommerce\OptionValue::class, rand(3, 4))->make());
            }
        });

        factory(Packages\Ecommerce\User::class, 5)
            ->create()
            ->each(function ($u) {
                $u->products()->saveMany(factory(Packages\Ecommerce\Product::class, rand(3, 5))->make())->each(function ($p) {
                    $faker = Faker\Factory::create();

                    $categories = \Packages\Ecommerce\Category::get();
                    $filters = \Packages\Ecommerce\Category::get();
                    $brands = \Packages\Ecommerce\Category::get();
                    $attributes = \Packages\Ecommerce\Attribute::get();
                    $tags = \Packages\Ecommerce\Tag::get();
                    $options = \Packages\Ecommerce\Option::get();

                    $p->images()->saveMany(factory(Packages\Ecommerce\ProductImage::class, rand(3, 5))->make());
                    $p->categories()->sync([$categories->random()->id]);
                    $p->filters()->sync([$brands->random()->id]);
                    $p->brands()->sync([$filters->random()->id]);
                    $p->tags()->sync($tags->random(3)->pluck('id')->toArray());

                    $pAttrs = [];

                    foreach ($attributes->random(4) as $attribute) {
                        $pAttrs[$attribute->id] = [
                            'value' => $faker->sentence(rand(3, 5)),
                        ];
                    }

                    $p->attributes()->sync($pAttrs);

                    $pOptionValues = [];

                    foreach ($options->random(2) as $option) {
                        if ($option->hasManyValues()) {
                            foreach ($option->values->random(3)->all() as $value) {
                                $pOptionValues[$value->id] = [
                                    'price' => collect(['+', '-'])->random().rand(1, 9).rand(1, 9).'000',
                                    'quantity' => rand(1, 5),
                                    'subtract' => rand(1, 0),
                                ];
                            }
                        }
                    }
                    
                    $p->optionValues()->sync($pOptionValues);
                });
            });
    }
}
