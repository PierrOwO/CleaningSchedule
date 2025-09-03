<?php

namespace App\Services;

use App\Models\CleaningQueue;

class CleaningQueueService
{
    public function check(string $data): array
    {   if(!$data)
    {
        return [
            'success' => false,
        ];
    }
        return [
            'success' => true,
            'data' => $data,
        ];
    }
    public function get($id)
    {
        $result = CleaningQueue::where('house', $id)->first();
        if (!$result)
        {
            return [
                'success' => false,
                'queue' => [],
            ];
        }
        $queue = $result->queue;
        $rotation = $result->rotation;
        $data = [
            'queue' => $queue,
            'rotation' => $rotation
        ];
        return [
            'success' => true,
            'queue' => $data
        ];
    }
    public function new($house, $json, $date, $type)
    {
        $check = CleaningQueue::where('house', $house)->first();
        if($check)
        {
            return [
                'success' => false,
                'message' => 'Schedule already exists!',
            ];
        }
        $new = new CleaningQueue;
        $new->type = $type;
        $new->rotation = $json;
        $new->house = $house;
        $new->start_date = $date;
        $result = $new->save();
        if (!$result)
        {
            return [
                'success' => false,
                'message' => 'error while processing',
            ];
        }
        return [
            'success' => true,
            'message' => 'Schedule set successfully!'
        ];
    }
    public function update($id, $json, $start_date, $type)
    {
        $update = CleaningQueue::where('id', $id)->first();
        $update->start_date = $start_date;
        $update->rotation = $json;
        $update->type = $type;
        $result = $update->save();
        if (!$result)
        {
            return [
                'success' => false,
                'message' => 'error while processing',
            ];
        }
        return [
            'success' => true,
            'message' => 'Schedule updated successfully!'
        ];
        
    }
    public function delete($id)
    {
        $delete = CleaningQueue::where('id', $id)->delete();
        if (!$delete)
        {
            return [
                'success' => false,
                'message' => 'error while processing',
            ];
        }
        return [
            'success' => true,
            'message' => 'Schedule deleted successfully!'
        ];
    }
}