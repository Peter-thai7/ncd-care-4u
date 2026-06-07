<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. ตารางคลังหมวดหมู่ค่าใช้จ่าย (แอดมินจัดการ)
        Schema::create('sp4u_expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ชื่อหมวดหมู่ (เช่น ค่ายา, ค่าอาหารเสริม)
            $table->boolean('is_wasteful')->default(false); // ติ๊กว่าเป็นค่าใช้จ่ายสิ้นเปลือง/ไม่จำเป็น
            $table->boolean('is_active')->default(true); // สถานะการแสดงผล (ระงับ/ซ่อน)
            $table->integer('sort_order')->default(0); // ลำดับการแสดงผล (Drag & Drop)
            $table->timestamps();
            $table->softDeletes(); // ป้องกันการลบถาวร
        });

        // 2. ตารางบันทึกค่าใช้จ่ายของผู้ใช้ (Transaction-based)
        Schema::create('sp4u_user_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // ผูกกับตาราง users
            $table->foreignId('expense_category_id')->constrained('sp4u_expense_categories')->cascadeOnDelete();
            
            $table->boolean('is_historical_estimate')->default(false); // เป็นการประเมินย้อนหลังแบบก้อนหรือไม่
            $table->string('item_name'); // ชื่อรายการ
            $table->string('brand')->nullable(); // ยี่ห้อ
            $table->decimal('quantity', 10, 2)->default(1); // จำนวน
            $table->decimal('price_per_unit', 10, 2)->default(0); // ราคาต่อหน่วย
            $table->decimal('total_amount', 10, 2)->default(0); // ยอดรวมสุทธิ
            $table->date('expense_date'); // วันที่จ่ายเงินจริงตามใบเสร็จ (รองรับย้อนหลัง)
            
            // เก็บ Path รูปภาพแบบ JSON Array (รองรับ Max 3 ภาพ, Relative Path)
            $table->json('product_image_paths')->nullable(); 
            // เช่น ["uploads/expenses/1/abc.jpg", "uploads/expenses/1/def.jpg"]
            
            $table->text('notes')->nullable(); // บันทึกเพิ่มเติม
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. ตารางตั้งค่าข้อความหน้าจอรายงาน (Dynamic UI Texts)
        Schema::create('sp4u_expense_ui_settings', function (Blueprint $table) {
            $table->id();
            $table->string('section'); // ส่วนของหน้าจอ (เช่น report_header, monthly_column)
            $table->string('label_key')->unique(); // คีย์อ้างอิง (เช่น header_yearly_report)
            $table->string('label_value'); // ข้อความที่ต้องการให้แสดง
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp4u_expense_ui_settings');
        Schema::dropIfExists('sp4u_user_expenses');
        Schema::dropIfExists('sp4u_expense_categories');
    }
};