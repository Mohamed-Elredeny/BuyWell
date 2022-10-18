<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Product;
use App\Models\Slider;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        #region Country City Area
        Country::create([
            'name_ar' => 'country_1_ar',
            'name_en' => 'country_1_en',
        ]);
        Country::create([
            'name_ar' => 'country_2_ar',
            'name_en' => 'country_2_en',
        ]);
        City::create([
            'name_ar' => 'city_1_ar',
            'name_en' => 'city_1_en',
            'country_id' => 1
        ]);
        City::create([
            'name_ar' => 'city_2_ar',
            'name_en' => 'city_2_en',
            'country_id' => 1
        ]);
        Area::create([
            'name_ar' => 'area_1_ar',
            'name_en' => 'area_1_en',
            'city_id' => 1
        ]);
        Area::create([
            'name_ar' => 'area_2_ar',
            'name_en' => 'area_2_en',
            'city_id' => 1
        ]);
        Area::create([
            'name_ar' => 'area_2_ar',
            'name_en' => 'area_2_en',
            'city_id' => 1
        ]);
        #endregion

        Category::create([
            'name_ar' => 'cat_ar_1',
            'name_en' => 'cat_en_1',
            'image' => asset('assets/images/categories/1660259565.png')
        ]);
        Category::create([
            'name_ar' => 'cat_ar_2',
            'name_en' => 'cat_en_2',
            'image' => asset('assets/images/categories/1660259565.png')
        ]);
        Category::create([
            'name_ar' => 'cat_ar_2',
            'name_en' => 'cat_en_2',
            'image' => asset('assets/images/categories/1660259565.png')
        ]);

        SubCategory::create([
            'name_ar' => 'sub_cat_ar_1',
            'name_en' => 'sub_cat_en_1',
            'category_id' => 1,
            'image' => asset('assets/images/categories/1660259565.png')
        ]);
        SubCategory::create([
            'name_ar' => 'sub_cat_ar_2',
            'name_en' => 'sub_cat_en_2',
            'category_id' => 1,
            'image' => asset('assets/images/categories/1660259565.png')
        ]);
        SubCategory::create([
            'name_ar' => 'sub_cat_ar_3',
            'name_en' => 'sub_cat_en_3',
            'category_id' => 2,
            'image' => asset('assets/images/categories/1660259565.png')
        ]);
        SubSubCategory::create([
            'name_ar' => 'sub_sub_cat_ar_1',
            'name_en' => 'sub_sub_cat_en_1',
            'sub_category_id' => 1,
            'image' => asset('assets/images/categories/1660259565.png')
        ]);
        SubSubCategory::create([
            'name_ar' => 'sub_sub_cat_ar_2',
            'name_en' => 'sub_sub_cat_en_2',
            'sub_category_id' => 1,
            'image' => asset('assets/images/categories/1660259565.png')
        ]);

        Slider::create([
            'title' => 'title_1',
            'link' => 'https://youtube.com/',
            'image' => asset('assets/images/categories/1660259565.png')
        ]);
        Slider::create([
            'title' => 'title_2',
            'link' => 'https://youtube.com/',
            'image' => asset('assets/images/categories/1660259565.png')
        ]);

        /**/

        $discount_type = ['percentage','fixed'];

        for($i=0;$i<10;$i++) {
            $model_type = 'category';
            $model_id = 1;

            //Categories => 1
            //Sub Cat=>1
            //Sub Sub Cat=>1


            //Products=> 1 => sub sub cat => 1
            //Products=> 1 => sub cat => 1

            $specifications = [
                'dimensions' => [
                    'height' => $request->dimensions['height'] ?? 1,
                    'weight' => $request->dimensions['weight'] ?? 2,
                    'length' => $request->dimensions['length'] ?? 3
                ],
                'shipping' => [
                    'price' => $request->shipping['price'] ?? 1,
                    'days_from' => $request->shipping['days_from'] ?? 2,
                    'days_to' => $request->shipping['days_to'] ?? 3,
                ],
                'specifications' => [
                    'material' => $request->specifications['material'] ?? 'mat',
                    'color' => $request->specifications['color'] ?? 'red',
                    'length' => $request->specifications['length'] ?? 10,
                    'fit' => $request->specifications['fit'] ?? '1',
                    'occasion' => $request->specifications['occasion'] ?? '',
                    'care' => $request->specifications['care'] ?? '123'
                ]
            ];
            $specifications = json_encode($specifications);

            //json_decode($record['specifications_' . APP::geolocation()])->specifications->color;

            $data = [
                'name_ar' => 'name_ar' . $i,
                'name_en' =>  'name_en' . $i,
                'specifications_ar' => $specifications,
                'specifications_en' => $specifications,
                'price' => rand(10,100),
                'discount_price' =>rand(0,10),
                'discount_type'=>$discount_type[rand(0,1)],
                'model_id' => $model_id,
                'model_type' => $model_type,
                'main_image' => '1662170371_123_.png',
                'images' => '1662170371_123_.png|1662170371_123_.png',
                'is_brand' => 1,
            ];
            Product::create($data);
        }
    }
}
