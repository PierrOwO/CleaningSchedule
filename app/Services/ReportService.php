<?php

namespace App\Services;

use App\Models\Report;

class ReportService
{
    public function new(string $name, string $status): array
    {   
        $report = new Report();
        $report->name = $name;
        $report->status = $status;
        $result = $report->save();
        if (!$result) {
            return [
                'success' => false,
                'message' => 'an error appeared while processing',
            ];
        }
        
        return [
            'success' => true,
            'message' => 'Created successfully'
        ];
    }

    public function check(string $id): array
    {
        $report = Report::find($id);
        if(!$report){
            return [
                'success' => false
            ];
        }
        return [
            'success' => true,
        ];
    }

    public function get(string $id): array
    {
        $report = Report::find($id);
        if (!$report) {
            return [
                'success' => false,
                'message' => 'No data found'
            ];
        }
        return [
            'success' => true,
            'message' => 'Data found',
            'report' => $report
        ];
    }
    public function update(string $id, string $name, string $status)
    {
        $report = Report::find($id);
        if (!$report) {
            return [
                'success' => false,
                'message' => 'No data found'
            ];
        }

        $report->name = $name;
        $report->status = $status;
        $result = $report->save();

        if (!$result){
            return [
                'success' => false,
                'message' => 'Update failed'
            ];
        }

        return [
            'success' => true,
            'message' => 'Updated successfully'
        ];
    }
    
    public function delete(string $id): array
    {
        $delete = Report::find($id)->delete();
        
        if(!$delete){
            return [
                'success' => false,
                'message' => 'Delete failed'
            ];
        }

        return [
            'success' => true,
            'message' => 'Deleted successfully'
        ];
    }
}