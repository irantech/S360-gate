<?php
class wholeSystemSalesInformation extends clientAuth
{
    protected $ticket_model;
    protected $hotel_model;

    protected $train_model;
    protected $bus_model;
    protected $insurance_model;
    protected $tour_model;
    protected $visa_model;
    protected $entertainment_model;
    protected $gasht_model;

    protected $transaction_model;


    public function __construct() {
        parent::__construct();
        $this->ticket_model = $this->getModel('bookLocalModel');
        $this->hotel_model = $this->getModel('bookHotelLocalModel');
        $this->train_model = $this->getModel('bookTrainModel');
        $this->bus_model = $this->getModel('bookBusModel');
        $this->insurance_model = $this->getModel('bookInsuranceModel');
        $this->tour_model = $this->getModel('bookTourLocalModel');
        $this->visa_model = $this->getModel('bookVisaModel');
        $this->entertainment_model = $this->getModel('bookEntertainmentModel');
        $this->gasht_model = $this->getModel('bookGashtLocalModel');
        $this->transaction_model = $this->getModel('transactionModel');
    }

    public function ShowTotalSales()
    {

        //ticket
        $fields1 = [
            "COUNT(DISTINCT factor_number) AS total_sales_ticket",
            "SUM(adt_qty) + SUM(chd_qty) + SUM(inf_qty) AS total_passengers_ticket",
            "SUM(adt_price) + SUM(chd_price) + SUM(inf_price)  AS total_selling_price_ticket"
        ];
        $TicketSalesInformation = $this->ticket_model
            ->get($fields1, true)
            ->where('successfull', 'book')
            ->find();

        //hotel
        $fields2 = [
            "factor_number",
            "MAX(room_count) AS room_count",
            "MAX(total_price) AS total_price"
        ];
        $groupedSalesHotel = $this->hotel_model
            ->get($fields2)
            ->where('status', 'BookedSuccessfully')
            ->groupBy('factor_number')
            ->all();

        $total_sales_hotel = count($groupedSalesHotel);
        $total_room_hotel = 0;
        $total_selling_price_hotel = 0;

        foreach ($groupedSalesHotel as $row) {
            $total_room_hotel += $row['room_count'];
            $total_selling_price_hotel += $row['total_price'];
        }

        $total_passengers_hotel = $this->hotel_model
            ->get(['COUNT(id) AS sum_passengers'], true)
            ->where('status', 'BookedSuccessfully')
            ->find();

        //train
        $groupedTrainSales = $this->train_model
            ->get([
                'factor_number',
                'SUM(Adult) AS sum_adult',
                'SUM(Child) AS sum_child',
                'SUM(Infant) AS sum_infant',
                'MAX(FullPrice) AS price'  // چون در هر فاکتور قیمت تکراری است، یکی را بگیر
            ])
            ->where('successfull', 'book')
            ->groupBy('factor_number')
            ->all();
        $total_sales_train = count($groupedTrainSales);
        $total_passengers_train = 0;
        $total_selling_price_train = 0;

        foreach ($groupedTrainSales as $row) {
            $total_passengers_train += $row['sum_adult'] + $row['sum_child'] + $row['sum_infant'];
            $total_selling_price_train += $row['price'];
        }

        //bus
        $fields4 = [
            "passenger_factor_num",
            "MAX(passenger_number) AS total_passengers",
            "MAX(total_price) AS total_price"
        ];
        $groupedSalesBus = $this->bus_model
            ->get($fields4)
            ->where('status', 'book')
            ->where('passenger_number', 1,' >=')
            ->groupBy('passenger_factor_num')
            ->all();

        $total_sales_bus = count($groupedSalesBus);
        $total_passengers_bus = 0;
        $total_selling_price_bus = 0;
        foreach ($groupedSalesBus as $row) {
            $total_passengers_bus += $row['total_passengers'];
            $total_selling_price_bus += $row['total_price'];
        }

        //insurance
        $fields5 = [
            "factor_number",
            "sum(paid_price) AS total_price"
        ];
        $groupedSalesInsurance = $this->insurance_model
            ->get($fields5)
            ->where('status', 'book')
            ->groupBy('factor_number')
            ->all();

        $total_sales_insurance= count($groupedSalesInsurance);
        $total_selling_price_insurance = 0;
        foreach ($groupedSalesInsurance as $row) {
            $total_selling_price_insurance += $row['total_price'];
        }
        $total_passengers_insurance = $this->insurance_model
            ->get(['COUNT(id) AS sum_passengers'], true)
            ->where('status', 'book')
            ->find();

        //tour
        $fields6 = [
            "factor_number",
            "MAX(total_price) AS total_price"
        ];
        $groupedSalesTour = $this->tour_model
            ->get($fields6)
            ->where('status', 'BookedSuccessfully')
            ->groupBy('factor_number')
            ->all();

        $total_sales_tour= count($groupedSalesTour);
        $total_selling_price_tour = 0;
        foreach ($groupedSalesTour as $row) {
            $total_selling_price_tour += $row['total_price'];
        }
        $total_passengers_tour = $this->tour_model
            ->get(['COUNT(id) AS sum_passengers'], true)
            ->where('status', 'BookedSuccessfully')
            ->find();

        //visa
        $fields7 = [
            "factor_number",
            "MAX(total_price) AS total_price"
        ];
        $groupedSalesVisa = $this->visa_model
            ->get($fields7)
            ->where('status', 'book')
            ->groupBy('factor_number')
            ->all();

        $total_sales_visa= count($groupedSalesVisa);
        $total_selling_price_visa = 0;
        foreach ($groupedSalesVisa as $row) {
            $total_selling_price_visa += $row['total_price'];
        }
        $total_passengers_visa = $this->visa_model
            ->get(['COUNT(id) AS sum_passengers'], true)
            ->where('status', 'book')
            ->find();

        //entertainment
        $fields8 = [
            "factor_number",
            "MAX(FullPrice) AS total_price"
        ];
        $groupedSalesEntertainment = $this->entertainment_model
            ->get($fields8)
            ->where('successfull', 'book')
            ->groupBy('factor_number')
            ->all();

        $total_sales_entertainment= count($groupedSalesEntertainment);
        $total_selling_price_entertainment = 0;
        foreach ($groupedSalesEntertainment as $row) {
            $total_selling_price_entertainment += $row['total_price'];
        }
        $total_passengers_entertainment = $this->entertainment_model
            ->get(['COUNT(id) AS sum_passengers'], true)
            ->where('successfull', 'book')
            ->find();

        //gasht
        $fields9 = [
            "passenger_factor_num",
            "MAX(passenger_number) AS total_passengers",
            "MAX(passenger_servicePriceAfterOff) AS price",
            "MAX(tax) AS tax"
        ];
        $groupedSalesGasht = $this->gasht_model
            ->get($fields9)
            ->where('status', 'book')
            ->groupBy('passenger_factor_num')
            ->all();

        $total_sales_gasht = count($groupedSalesGasht);
        $total_passengers_gasht = 0;
        $total_selling_price_gasht = 0;
        foreach ($groupedSalesGasht as $row) {
            $total_passengers_gasht += $row['total_passengers'];
            $total_selling_price_gasht += ($row['price']+$row['tax']);
        }

        //transaction
        $fields = [
            "Reason",
            "SUM(Price) AS total_paid"
        ];

        $reasons = [
            'buy_reservation_ticket',
            'buy',
            'buy_reservation_hotel',
            'buy_hotel',
            'buy_train',
            'buy_bus',
            'buy_insurance',
            'buy_reservation_tour',
            'buy_reservation_visa',
            'buy_visa_plan',
            'buy_entertainment',
            'buy_gasht_transfer'
        ];

        $TransactionByReason = $this->transaction_model
            ->get($fields, true)
            ->where('Status', 2)
            ->where('PaymentStatus', 'success')
            ->whereIn('Reason', $reasons)
            ->groupBy('Reason')
            ->all();
        $arrTransaction = [];
        foreach ($TransactionByReason as $row) {
            $arrTransaction[$row['Reason']] = (int) $row['total_paid'];
        }

        //Mohasebe profit
            //ticket 2 halat darad
        $total_profit_ticket = isset($arrTransaction['buy_reservation_ticket'])
            ? floatval($TicketSalesInformation['total_selling_price_ticket']) - floatval($arrTransaction['buy_reservation_ticket'])
            : floatval($TicketSalesInformation['total_selling_price_ticket']);
        $total_profit_ticket = isset($arrTransaction['buy'])
            ? floatval($total_profit_ticket) - floatval($arrTransaction['buy'])
            : floatval($total_profit_ticket);
            //hotel 2 halat darad
        $total_profit_hotel = isset($arrTransaction['buy_reservation_hotel'])
            ? floatval($total_selling_price_hotel) - floatval($arrTransaction['buy_reservation_hotel'])
            : floatval($total_selling_price_hotel);

        $total_profit_hotel = isset($arrTransaction['buy_hotel'])
            ? floatval($total_profit_hotel) - floatval($arrTransaction['buy_hotel'])
            : floatval($total_profit_hotel);

        $total_profit_train = isset($arrTransaction['buy_train'])
            ? floatval($total_selling_price_train) - floatval($arrTransaction['buy_train'])
            : floatval($total_selling_price_train);

        $total_profit_bus = isset($arrTransaction['buy_bus'])
            ? floatval($total_selling_price_bus) - floatval($arrTransaction['buy_bus'])
            : floatval($total_selling_price_bus);

        $total_profit_insurance = isset($arrTransaction['buy_insurance'])
            ? floatval($total_selling_price_insurance) - floatval($arrTransaction['buy_insurance'])
            : floatval($total_selling_price_insurance);

        $total_profit_tour = isset($arrTransaction['buy_reservation_tour'])
            ? floatval($total_selling_price_tour) - floatval($arrTransaction['buy_reservation_tour'])
            : floatval($total_selling_price_tour);

           //visa 2 halat darad
        $total_profit_visa = isset($arrTransaction['buy_reservation_visa'])
            ? floatval($total_selling_price_visa) - floatval($arrTransaction['buy_reservation_visa'])
            : floatval($total_selling_price_visa);

        $total_profit_visa = isset($arrTransaction['buy_visa_plan'])
            ? floatval($total_profit_visa) - floatval($arrTransaction['buy_visa_plan'])
            : floatval($total_profit_visa);

        $total_profit_entertainment = isset($arrTransaction['buy_entertainment'])
            ? floatval($total_selling_price_entertainment) - floatval($arrTransaction['buy_entertainment'])
            : floatval($total_selling_price_entertainment);

        $total_profit_gasht = isset($arrTransaction['buy_gasht_transfer'])
            ? floatval($total_selling_price_gasht) - floatval($arrTransaction['buy_gasht_transfer'])
            : floatval($total_selling_price_gasht);

        //return
        $combined = [
            'total_sales_ticket' => number_format($TicketSalesInformation['total_sales_ticket']),
            'total_passengers_ticket' => number_format($TicketSalesInformation['total_passengers_ticket']),
            'total_selling_price_ticket' => number_format(floatval($TicketSalesInformation['total_selling_price_ticket'])),
            'total_profit_ticket' => number_format($total_profit_ticket),

            'total_sales_hotel' => number_format($total_sales_hotel),
            'total_passengers_hotel' => number_format($total_passengers_hotel['sum_passengers']),
            'total_room_hotel' => number_format($total_room_hotel),
            'total_selling_price_hotel' => number_format(floatval($total_selling_price_hotel)),
            'total_profit_hotel' => number_format($total_profit_hotel),

            'total_sales_train' => number_format($total_sales_train),
            'total_passengers_train' => number_format($total_passengers_train),
            'total_selling_price_train' => number_format(floatval($total_selling_price_train)),
            'total_profit_train' => number_format($total_profit_train),

            'total_sales_bus' => number_format($total_sales_bus),
            'total_passengers_bus' => number_format($total_passengers_bus),
            'total_selling_price_bus' => number_format(floatval($total_selling_price_bus)),
            'total_profit_bus' => number_format($total_profit_bus),

            'total_sales_insurance' => number_format($total_sales_insurance),
            'total_passengers_insurance' => number_format($total_passengers_insurance['sum_passengers']),
            'total_selling_price_insurance' => number_format(floatval($total_selling_price_insurance)),
            'total_profit_insurance' => number_format($total_profit_insurance),

            'total_sales_tour' => number_format($total_sales_tour),
            'total_passengers_tour' => number_format($total_passengers_tour['sum_passengers']),
            'total_selling_price_tour' => number_format(floatval($total_selling_price_tour)),
            'total_profit_tour' => number_format($total_profit_tour),

            'total_sales_visa' => number_format($total_sales_visa),
            'total_passengers_visa' => number_format($total_passengers_visa['sum_passengers']),
            'total_selling_price_visa' => number_format(floatval($total_selling_price_visa)),
            'total_profit_visa' => number_format($total_profit_visa),

            'total_sales_entertainment' => number_format($total_sales_entertainment),
            'total_passengers_entertainment' => number_format($total_passengers_entertainment['sum_passengers']),
            'total_selling_price_entertainment' => number_format(floatval($total_selling_price_entertainment)),
            'total_profit_entertainment' => number_format($total_profit_entertainment),

            'total_sales_gasht' => number_format($total_sales_gasht),
            'total_passengers_gasht' => number_format($total_passengers_gasht),
            'total_selling_price_gasht' => number_format(floatval($total_selling_price_gasht)),
            'total_profit_gasht' => number_format($total_profit_gasht),


            // مجموع کل:
            'total_sales' => number_format(
                $TicketSalesInformation['total_sales_ticket']+
                $total_sales_hotel+
                $total_sales_train+
                $total_sales_bus+
                $total_sales_insurance+
                $total_sales_tour+
                $total_sales_visa+
                $total_sales_entertainment+
                $total_sales_gasht
            ),
            'total_passengers' => number_format(
                $TicketSalesInformation['total_passengers_ticket']+
                (int)$total_passengers_hotel['sum_passengers']+
                (int)$total_passengers_train+
                (int)$total_passengers_bus+
                (int)$total_passengers_insurance['sum_passengers']+
                (int)$total_passengers_tour['sum_passengers']+
                (int)$total_passengers_visa['sum_passengers']+
                (int)$total_passengers_entertainment['sum_passengers']+
                (int)$total_passengers_gasht
            ),
            'total_selling_price' => number_format(
                floatval($TicketSalesInformation['total_selling_price_ticket'])+
                floatval($total_selling_price_hotel)+
                floatval($total_selling_price_train)+
                floatval($total_selling_price_bus)+
                floatval($total_selling_price_insurance)+
                floatval($total_selling_price_tour)+
                floatval($total_selling_price_visa)+
                floatval($total_selling_price_entertainment)+
                floatval($total_selling_price_gasht)
            ),
            'total_profit_price' => number_format(
                $total_profit_ticket +
                $total_profit_hotel +
                $total_profit_train +
                $total_profit_bus +
                $total_profit_insurance +
                $total_profit_tour +
                $total_profit_visa +
                $total_profit_entertainment +
                $total_profit_gasht
            )
        ];
        return $combined;
    }
}
