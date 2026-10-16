<?php

namespace App\Repository\Api\Assessments;

use App\Interface\Api\Assessments\OptionInterface;
use App\Models\Option;
use App\Trait\RepositoryTrait;

class OptionRepository implements OptionInterface
{
    use RepositoryTrait;

    // get an option by id
    public function getOptionById(string $id)
    {
        $option = Option::find($id);
        if (!$option) {
            return $this->returnData(false, 'Option not found', 404);
        }
        return $this->returnData(true, 'Option retrieved successfully', 200, $option);
    }

    // update an option
    public function updateOption(string $id, array $data)
    {
        $option = Option::find($id);
        if (!$option) {
            return $this->returnData(false, 'Option not found', 404);
        }
        $option->update([
            'option_text' => $data['option_text'],
            'is_correct' => $data['is_correct'],
            'order' => $data['order'],
        ]);
        return $this->returnData(true, 'Option updated successfully', 200, $option);
    }

    // delete an option
    public function deleteOption(string $id)
    {
        $option = Option::find($id);
        if (!$option) {
            return $this->returnData(false, 'Option not found', 404);
        }
        $option->delete();
        return $this->returnData(true, 'Option deleted successfully', 200);
    }
}
