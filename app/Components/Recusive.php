<?php
namespace App\Components;

use App\Models\Category;

class Recusive
{
    // Khai báo thuộc tính htmlSelect
    private $data;
    protected $htmlSelect = '';

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function categoryResusive($parentId, $id = 0, $text = "")
    {
        // Duyệt qua từng danh mục
        foreach ($this->data as $value) {
            // Nếu danh mục có parent_id trùng với $id được truyền vào
            if ($value['parent_id'] == $id) {
                // Kiểm tra nếu option cần được chọn
                $isSelected = !empty($parentId) && $parentId == $value['id'];

                if ($isSelected) {
                    // Thêm option với thuộc tính 'selected'
                    $this->htmlSelect .= "<option selected value='" . $value['id'] . "'>" . $text . $value['name'] . "</option>";
                } else {
                    // Thêm option bình thường
                    $this->htmlSelect .= "<option value='" . $value['id'] . "'>" . $text . $value['name'] . "</option>";
                }

                // Gọi đệ quy với id của danh mục hiện tại và tiền tố mới là $text . '-'
                $this->categoryResusive($parentId, $value['id'], $text . '-');
            }
        }

        // Trả về chuỗi htmlSelect
        return $this->htmlSelect;
    }

}
