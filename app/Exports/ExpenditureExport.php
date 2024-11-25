<?php

namespace App\Exports;

use App\Models\Expenditure;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExpenditureExport implements FromCollection, WithHeadings
{
    protected $expenditures;

    // Pass filtered expenditures to the constructor
    public function __construct($expenditures)
    {
        $this->expenditures = $expenditures;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->expenditures->map(function ($expenditure) {
            return [
                $expenditure->id,
                $expenditure->donation_type ?? 'N/A',
                $expenditure->ammount,
                $expenditure->note ?? 'N/A',
                $expenditure->debit_or_credit,
                \Carbon\Carbon::parse($expenditure->date)->format('dM, Y h:i A'),
                $expenditure->unique_personal_doc_name ?? 'N/A',
                $expenditure->unique_personal_doc_id ?? 'N/A',
                $expenditure->id_code ?? 'N/A',
                $expenditure->section_code ?? 'N/A',
                $expenditure->name_of_donor ?? 'N/A',
                $expenditure->address_of_donor ?? 'N/A',
                $expenditure->payment_mode ?? 'N/A',
                $expenditure?->member?->name  ?? 'N/A',


            ];
        });
    }

    public function headings(): array
    {
        return [
            'SL',
            'Category',
            'Amount',
            'Note',
            'Type',
            'Date',
            'Personal Document',
            'Document Number',
            'ID Code',
            'Section Code',
            'Name of Donor',
            'Address of Donor',
            'Payment Mode',
            'Member/Stuff',
        ];
    }
}
