<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{


    const LIST = [
        "প্রচ্ছদ",
        "জাতীয়",
        "রাজনীতি",
        "অর্থনীতি",
        "আন্তর্জাতিক",
        "সারাদেশ",
        "খেলা",
        "বিনোদন",
        "লাইফ স্টাইল",
        "শিক্ষাঙ্গন",
        "স্বপ্নের পদ্মা সেতু",
        "আইটি বিশ্ব",
        "অটোটেক",
        "ইসলাম ও জীবন",
        "রাজধানী",
        "মার্কিন নির্বাচন",
        "পরবাস",
        "একদিন প্রতিদিন",
        "সম্পাদকীয়",
        "দৃষ্টিপাত",
        "বাতায়ন",
        "স্বজন সমাবেশ",
        "প্রতিমঞ্চ",
        "সোশ্যাল মিডিয়া",
        "সাহিত্য",
        "ডাক্তার আছেন",
        "চিত্র বিচিত্র",
        "বিচ্ছু",
        "সাক্ষাৎকার",
        "সুরঞ্জনা",
        "কর্পোরেট নিউজ",
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(static::LIST as $title){
            $slug = Str::slug($title);
            Category::create(compact('title','slug'));
        }
    }
}
