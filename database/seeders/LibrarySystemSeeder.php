<?php

namespace Database\Seeders;

use App\Models\MasterMenu;
use App\Models\ExerciseLibrary;
use Illuminate\Database\Seeder;

class LibrarySystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * ข้อมูลตัวอย่างสำหรับคลังเมนูอาหารและท่าบริหาร
     */
    public function run(): void
    {
        $this->seedMasterMenus();
        $this->seedExerciseLibraries();

        $this->command->info('✅ Library System Seeder: สร้างข้อมูลตัวอย่างเสร็จสมบูรณ์');
    }

    private function seedMasterMenus(): void
    {
        $menus = [
            [
                'name' => 'สลัดไก่นึ่งสมุนไพร',
                'description' => 'สลัดผักสดเคียงเครื่องเทศไทย ราดด้วยอกไก่นึ่งนุ่ม เหมาะสำหรับคนที่ต้องการลดน้ำหนักและควบคุมน้ำตาล',
                'category' => 'lunch',
                'calories' => 280,
                'protein' => 32.5,
                'carbs' => 15.0,
                'fat' => 8.5,
                'fiber' => 4.2,
                'sodium' => 320,
                'ingredients' => "อกไก่ 150 กรัม\nผักสลัด Mix 100 กรัม\nมะเขือเทศเชอร์รี่ 50 กรัม\nแครอทขูด 30 กรัม\nเครื่องเทศ: ขิง, ตะไคร้, ใบโหระพา\nน้ำสลัด: น้ำมะนาว 2 ช้อนโต๊ะ, น้ำมันมะกอก 1 ช้อนโต๊ะ",
                'instructions' => "1. ลวกอกไก่พร้อมเครื่องเทศไทยจนสุกนุ่ม\n2. หั่นไก่เป็นชิ้นพอคำ\n3. ล้างผักสลัดให้สะอาด สะเด็ดน้ำ\n4. จัดผักใส่จาน วางไก่ด้านบน\n5. ราดด้วยน้ำสลัดมะนาวทันทีก่อนทาน",
                'preparation_time' => 25,
                'serving_size' => '1 จาน',
                'difficulty_level' => 'easy',
                'suitable_for' => ['diabetes', 'obesity', 'hyperlipidemia'],
                'tags' => ['ลดน้ำหนัก', 'โปรตีนสูง', 'ไขมันต่ำ'],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'ข้าวกะเพราไก่ (เพื่อสุขภาพ)',
                'description' => 'ข้าวกะเพราไก่สูตรลดน้ำมัน ใช้น้ำมันมะกอกแทนน้ำมันปาล์ม ลดเกลือ แต่ยังคงรสชาติเผ็ดหอม',
                'category' => 'lunch',
                'calories' => 380,
                'protein' => 28.0,
                'carbs' => 42.0,
                'fat' => 10.5,
                'fiber' => 2.8,
                'sodium' => 450,
                'ingredients' => "อกไก่หั่น 120 กรัม\nใบกะเพรา 1 กำ\nพริกขี้หนู 3-5 เม็ด\nกระเทียม 4 กลีบ\nน้ำมันมะกอก 1 ช้อนชา\nข้าวกล้อง 1 ทัพพี\nซอสหอยนางรม 1 ช้อนชา (ลดลง)",
                'instructions' => "1. ตั้งกระทะไฟกลาง ใส่น้ำมันมะกอก\n2. ผัดกระเทียมและพริกให้หอม\n3. ใส่ไก่ผัดจนสุก\n4. ปรุงรสด้วยซอสหอยนางรม (ใส่น้อย)\n5. ใส่ใบกะเพรา ผัดเร็วๆ พอลู่ลง\n6. ตักขึ้นเสิร์ฟกับข้าวกล้อง",
                'preparation_time' => 15,
                'serving_size' => '1 จาน',
                'difficulty_level' => 'easy',
                'suitable_for' => ['diabetes', 'hypertension'],
                'tags' => ['อาหารไทย', 'ลดเกลือ', 'ข้าวกล้อง'],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'โอ๊ตมืลผลไม้ต้ม',
                'description' => 'โอ๊ตมืลต้มกับนมอัลมอนด์ ใส่ผลเบอร์รี่และเมล็ดเจีย อุดมด้วยใยอาหาร เหมาะสำหรับมื้อเช้าของคนเบาหวาน',
                'category' => 'breakfast',
                'calories' => 220,
                'protein' => 8.0,
                'carbs' => 32.0,
                'fat' => 6.5,
                'fiber' => 6.0,
                'sodium' => 85,
                'ingredients' => "โอ๊ตมืล 40 กรัม\nนมอัลมอนด์ไม่หวาน 200 มล.\nเมล็ดเจีย 1 ช้อนโต๊ะ\nบลูเบอร์รี่ 30 กรัม\nสตรอว์เบอร์รี่หั่น 30 กรัม\nวัลนัท 5 ซีก",
                'instructions' => "1. ต้มโอ๊ตมืลกับนมอัลมอนด์จะนุ่ม\n2. ใส่เมล็ดเจียลงไป คนให้เข้ากัน\n3. ตักใส่ชาม ตกแต่งด้วยผลเบอร์รี่และวัลนัท\n4. ทานอุ่นๆ",
                'preparation_time' => 10,
                'serving_size' => '1 ชาม',
                'difficulty_level' => 'easy',
                'suitable_for' => ['diabetes', 'hyperlipidemia', 'heart_disease'],
                'tags' => ['มื้อเช้า', 'ใยอาหารสูง', 'โอ๊ต'],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'น้ำผักใบเขียวดีท็อกซ์',
                'description' => 'น้ำผักคั้นสด ผสมผักใบเขียวหลายชนิด ช่วยฟื้นฟูร่างกายและลดการอักเสบ',
                'category' => 'beverage',
                'calories' => 65,
                'protein' => 2.0,
                'carbs' => 12.0,
                'fat' => 0.5,
                'fiber' => 3.0,
                'sodium' => 50,
                'ingredients' => "ผักโขม 50 กรัม\nคะน้า 50 กรัม\nแอปเปิลเขียว 1 ผล\nขิงสด 1 ชิ้นเล็ก\nมะนาว 1 ผล\nน้ำเปล่า 100 มล.",
                'instructions' => "1. ล้างผักทุกชนิดให้สะอาด\n2. หั่นแอปเปิลและขิงเป็นชิ้นเล็ก\n3. ใส่ผัก แอปเปิล ขิง ลงเครื่องคั้น\n4. คั้นจนละเอียด\n5. บีบมะนาวเติม คนให้เข้ากัน\n6. ดื่มทันที (ไม่ควรเก็บนาน)",
                'preparation_time' => 10,
                'serving_size' => '1 แก้ว (250 มล.)',
                'difficulty_level' => 'easy',
                'suitable_for' => ['diabetes', 'hypertension', 'kidney_disease'],
                'tags' => ['น้ำผัก', 'ดีท็อกซ์', 'ลดการอักเสบ'],
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'ปลานึ่งมะนาว (ต้นฉบับโบราณ)',
                'description' => 'ปลากะพงนึ่งเครื่องเทศไทยแท้ รสเปรี้ยวนุ่ม ไม่เผ็ดจัด โปรตีนสูง ไขมันต่ำ',
                'category' => 'dinner',
                'calories' => 250,
                'protein' => 35.0,
                'carbs' => 8.0,
                'fat' => 7.5,
                'fiber' => 1.5,
                'sodium' => 380,
                'ingredients' => "ปลากะพง 1 ตัว (~200 กรัม)\nมะนาว 3 ผล\nกระเทียม 5 กลีบ\nพริกขี้หนู 2 เม็ด\nใบโหระพา 5 ใบ\nรากผักชี 1 ราก\nน้ำตาลโครนาย 1 ช้อนชา\nซอสปลา 1 ช้อนชา",
                'instructions' => "1. ทำเครื่องปรุง: ตำกระเทียม พริก รากผักชี\n2. ปรุงรสด้วยน้ำมะนาว น้ำตาล ซอสปลา\n2. วางปลาบนจาน ราดเครื่องปรุงให้ทั่ว\n3. นำไปนึ่งไฟแรง 12-15 นาที\n4. โรยใบโหระพา เสิร์ฟร้อนๆ",
                'preparation_time' => 20,
                'serving_size' => '1 ที่',
                'difficulty_level' => 'medium',
                'suitable_for' => ['diabetes', 'hyperlipidemia', 'hypertension'],
                'tags' => ['โปรตีนสูง', 'อาหารไทย', 'ปลา'],
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($menus as $menu) {
            MasterMenu::create($menu);
        }

        $this->command->info('  ✅ สร้างเมนูอาหารตัวอย่าง ' . count($menus) . ' รายการ');
    }

    private function seedExerciseLibraries(): void
    {
        $exercises = [
            [
                'name' => 'ท่ายืดกล้ามเนื้อต้นขา (Quadriceps Stretch)',
                'description' => 'ท่ายืดกล้ามเนื้อด้านหน้าต้นขา เหมาะสำหรับผู้ที่นั่งทำงานนานๆ หรือผู้สูงอายุที่ต้องการเพิ่มความยืดหยุ่น',
                'category' => 'stretching',
                'video_url' => null,
                'duration_minutes' => 5,
                'difficulty_level' => 'easy',
                'calories_burned' => 15,
                'instructions' => "1. ยืนตรง จับเก้าอี้หรือผนังเพื่อทรงตัว\n2. งอเข่าด้านซ้าย ยับขึ้นมาด้านหลัง\3. จับข้อเท้าซ้ายด้วยมือซ้าย\n4. ดึงส้นเท้าเข้าหาก้นช้าๆ\n5. ค้างไว้ 15-30 วินาที\n6. สลับข้าง ทำซ้ำ 2-3 ครั้ง",
                'precautions' => "หากปวดเข่ารุนแรง ให้หยุดทันที\nไม่ควรดึงแรงจนเจ็บ\nผู้สูงอายุควรจับเก้าอี้เพื่อทรงตัว",
                'suitable_for' => ['obesity', 'joint_pain', 'diabetes'],
                'tags' => ['ยืดเส้น', 'ผู้สูงอายุ', 'ง่าย'],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'เดินเร็ว (Brisk Walking)',
                'description' => 'การเดินออกกำลังกายแบบเร่งจังหวะ ช่วยเผาผลาญไขมันและลดน้ำตาลในเลือด เหมาะสำหรับผู้เริ่มต้นออกกำลังกาย',
                'category' => 'walking_running',
                'video_url' => null,
                'duration_minutes' => 30,
                'difficulty_level' => 'easy',
                'calories_burned' => 150,
                'instructions' => "1. สวมรองเท้ากีฬาที่รองรับแผ่นรองเท้าดี\n2. เริ่มจากเดินช้าๆ 5 นาทีปรับตัว\n3. เร่งจังหวะเดินให้เร็วขึ้น (สามารถพูดได้แต่ร้องเพลงไม่ได้)\n4. แขวนแขนไปมาตามจังหวะ\n5. ก้าวยาวขึ้นเล็กน้อย\n6. ค่อยๆ ลดจังหวะ 5 นาทีสุดท้าย",
                'precautions' => "หากมีอาการเวียนศีรษะ หรือเจ็บหน้าอก ให้หยุดทันที\nควรดื่มน้ำก่อนและหลังออกกำลังกาย\nผู้ป่วยเบาหวานควรเตรียมลูกอนหวานติดตัว",
                'suitable_for' => ['diabetes', 'obesity', 'hypertension', 'hyperlipidemia'],
                'tags' => ['คาร์ดิโอ', 'เผาผลาญ', 'เริ่มต้น'],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'ท่าบริหารกล้ามเนื้อแกนกลาง (Core Stability)',
                'description' => 'ท่าบริหารกล้ามเนื้อหน้าท้องและหลังส่วนล่าง ช่วยลดอาการปวดหลังและเสริมสร้างความแข็งแรง',
                'category' => 'strength',
                'video_url' => null,
                'duration_minutes' => 15,
                'difficulty_level' => 'medium',
                'calories_burned' => 80,
                'instructions' => "ท่า 1 - Plank: คุกเข่า วางศอกบนพื้น ยกตัวให้เป็นเส้นตรง ค้าง 15-30 วินาที\nท่า 2 - Bird Dog: คุกเข่า ยืดแขนขวาและขาซ้ายออก ค้าง 5 วินาที สลับข้าง\nท่า 3 - Bridge: นอนหงาย งอเข่า ยกสะโพกขึ้น ค้าง 5 วินาที\nทำซ้ำแต่ละท่า 8-10 ครั้ง",
                'precautions' => "หากปวดหลังส่วนล่างรุนแรง ให้หลีกเลี่ยงท่า Plank\nไม่กลั้นหายใจขณะออกกำลังกาย\nควรทำบนพื้นรองนุ่ม",
                'suitable_for' => ['back_pain', 'obesity', 'diabetes'],
                'tags' => ['แกนกลาง', 'ลดปวดหลัง', 'เสริมกล้ามเนื้อ'],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'ท่าหายใจผ่อนคลาย (Diaphragmatic Breathing)',
                'description' => 'การหายใจโดยใช้กะบังลมช่วยลดความเครียด ลดความดันโลหิต และเพิ่มประสิทธิภาพปอด',
                'category' => 'breathing',
                'video_url' => null,
                'duration_minutes' => 10,
                'difficulty_level' => 'easy',
                'calories_burned' => 5,
                'instructions' => "1. นอนหงายหรือนั่งสบายๆ\n2. วางมือบนท้อง\n3. หายใจเข้าทางจมูกช้าๆ ให้ท้องพอง\n4. ค้างไว้ 2 วินาที\n5. หายใจออกทางปากช้าๆ ให้ท้องแฟบ\n6. ทำซ้ำ 10-15 รอบ\n7. สังเกตร่างกายผ่อนคลายลงเรื่อยๆ",
                'precautions' => "หากมีอาการวิงเวียน ให้หยุดพัก\nไม่ต้องหายใจลึกจนเกร็ง\nเหมาะสำหรับทำก่อนนอน",
                'suitable_for' => ['hypertension', 'heart_disease', 'diabetes'],
                'tags' => ['ผ่อนคลาย', 'ลดเครียด', 'หายใจ'],
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'โยคะท่านักรบ (Warrior Pose)',
                'description' => 'ท่าโยคะที่เสริมสร้างความแข็งแรงของขาและสะโพก พร้อมเปิดช่องอก เพิ่มความสมดุล',
                'category' => 'yoga',
                'video_url' => null,
                'duration_minutes' => 10,
                'difficulty_level' => 'medium',
                'calories_burned' => 45,
                'instructions' => "1. ยืนตรง ก้าวเท้าซ้ายออกด้านหลัง 1 เมตร\n2. หมุนเท้าซ้าย 45 องศา\n3. งอเข่าขวา 90 องศา (เข่าไม่เกินปลายเท้า)\n4. ชูแขนขึ้นเหนือศีรษะ หรือแยกออกด้านข้าง\n5. จ้องมองไปข้างหน้า ค้าง 30 วินาที\n6. สลับข้าง",
                'precautions' => "หากปวดเข่า ให้งอเข่าน้อยลง\nผู้สูงอายุอาจใช้เก้าอี้จับทรงตัว\nห้ามกลั้นหายใจ",
                'suitable_for' => ['obesity', 'back_pain', 'hypertension'],
                'tags' => ['โยคะ', 'สมดุล', 'เสริมกล้ามเนื้อ'],
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($exercises as $exercise) {
            ExerciseLibrary::create($exercise);
        }

        $this->command->info('  ✅ สร้างท่าบริหารตัวอย่าง ' . count($exercises) . ' ท่า');
    }
}
