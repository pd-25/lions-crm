<?php

namespace App\enum;

class ExpenditureCategoryEnum
{
    const SERVICE = 'Service';
    const ADMINISTRATIVE = 'Administrative';
    const WELFARE = 'Welfare';

    public static function categoriesByType(): array
    {
        return [
            'Credit' => [
                self::SERVICE => [
                    "IOI Collection",
                    "OPD Collection",
                    "Other Contribution",
                    "Donation",
                    "District Grant",
                    "ECG Collection",
                    "Oxygen Cylinder Collection",
                    "Interest on Bank",
                    "FD Interest",
                    "Surgical Fees Collection",
                    "Gene Physician Collect",
                    "Sale Proceeds Wastage",
                    "Closing Stock of Lence"
                ],
                self::ADMINISTRATIVE => [
                    "Bank Charges Refund",
                    "Interest on Bank",
                    "Old Member Subscription",
                    "New Member Subscription"
                ],
                self::WELFARE => [
                    "Lions Club Medicine Corner Sale",
                    "Burning Ghat Collection",
                    "Donation",
                    "Interest on Bank",
                    "Closing Stock of Medicine Corner"
                ]
            ],
            'Debit' => [
                self::SERVICE => [
                    'Opening Stock of Lence',
                    'Attendent',
                    'Bank Charges',
                    'Cable Connection Recharge',
                    'Carriage & Colliage',
                    'CCTV Maintenance',
                    'Computer Accessories',
                    'Conveyance',
                    'Cultural Programme',
                    'Doctor Charges',
                    'Doctor Assitant',
                    'Donation Paid',
                    'Blood Donation Camp Expenses',
                    'Employees Professional Tax',
                    'Entertainment',
                    'Exgratia',
                    'DG Advisory Meeting Expenses',
                    'Legal Expenses',
                    'Food for Hunger',
                    'Food Allowance of The Staff',
                    'Fire & Safety',
                    'Fuel For Generator',
                    'Income Tax',
                    'Accounts & Audit',
                    'Blood Sugar Detection Camp',
                    'Condolence Expenses',
                    'Employee Provident Fund',
                    'ECG Testing Charges',
                    'ECG Accessories',
                    'Gas Cylinder',
                    'Honorarium of The Optometrist',
                    'Honorarium of Gen Phy',
                    'Insurance',
                    'Furniture & Fittings',
                    'Medicine & Appliance',
                    'Website Maintenance',
                    'Misc Expenses',
                    'Net Recharge',
                    'News Paper',
                    'Out Reach Camp',
                    'Oxygen Cylind Refilling Charges',
                    'O.P.D Surgeon Fees Paid',
                    'O.T Assistant',
                    'Office Assistant',
                    'Publicity',
                    'Pathological Expenses',
                    'Printing & Stationery',
                    'Professional Tax',
                    'Patient Diet',
                    'Pollution Charges',
                    'Phaco Accessories',
                    'Postage & Courier',
                    'Premises Cleaning',
                    'Remuneration of Staff',
                    'Repair & Maintenance',
                    'Spectacles',
                    'Service Project',
                    'Swab Test Charges',
                    'Tree Plantation Expenses',
                    'Trade Licence',
                    'Lence Purchase',
                    'Washing Charges',
                    'Donation'
                ],
                self::ADMINISTRATIVE => [
                    'Bank Charges Refund',
                    'Old Member Subscription',
                    'Bank Charges',
                    'District & Multiple Dues',
                    'International Dues',
                    'Donation Paid Dist',
                    'Loan Repayment',
                    'Installation Meeting Expenses',
                    'Meeting Expenses',
                    'Telephone Expenses'
                ],
                self::WELFARE => [
                    'Burning Ghat Collection',
                    'Opening Stock of Medicine Corner',
                    'Lions Club Medical Corner Purchase',
                    'Bank Charges',
                    'Electric Bill',
                    'Exgratia',
                    'Municipal & Other Tax',
                    'Meeting Expenses',
                    'Printing & Stationery',
                    'Lence',
                    'Remuneration of Staff',
                    'Repair & Maintenance',
                    'Depreciation',
                    'Excess of Income over Expenditure'
                ]
            ]
        ];
    }

    public static function values(): array
    {
        return [
            self::SERVICE,
            self::ADMINISTRATIVE,
            self::WELFARE,
        ];
    }
}
