<?php
class reportAllSales extends clientAuth
{
	public $arr_Client = array();
	public $date_int_start='';
	public $date_int_end='';
	public $HtmlOutAjax='';
	public $IndexArrOutAjax=0;
	public $IndexHtml=1;

    public $result = array();

    public function __construct()
    {
        $this->listClient();
    }

    public function listClient(){
	   //@var clientsModel $model 
        $model = $this->getModel('clientsModel');
        $result = $model->get("
        clients_tb.id,
        clients_tb.AgencyName,
        clients_tb.Manager", true);
        $sql = $result->toSql();
        $result = $result->all();


		$Index=0;
		foreach ($result as $row_Client) {
			 $this->arr_Client[$Index]['ClientId'] = $row_Client['id'];
             $this->arr_Client[$Index]['NameAgency'] = $row_Client['AgencyName'];
             $this->arr_Client[$Index]['Manager'] = $row_Client['Manager'];
             $Index++;
		}

    }//end fun


   public function retrieveInformation($params = [])
    {
        $Arr_ShowListSalesAgency= [];
        $Arr_CountSales= [];

        $TotalFlight=$TotalTour=$TotalHotel=$TotalTrain=$TotalBus=$TotalVisa=$TotalInsurance=$TotalFlightGBF=$TotalTourGBF=$TotalHotelGBF=$TotalTrainGBF=$TotalVisaGBF=$TotalInsuranceGBF=$TotalSuccessFull = 0;

        $explode_start_date = explode( '-', $params['start_date'] );
        $explode_end_date   = explode( '-', $params['end_date'] );
        //convert to timestamp
        $this->date_int_start = dateTimeSetting::jmktime( 0, 0, 0, $explode_start_date[1], $explode_start_date[2], $explode_start_date[0] );
        $this->date_int_end   = dateTimeSetting::jmktime( 0, 0, 0, $explode_end_date[1], $explode_end_date[2], $explode_end_date[0] );

        $ArrResFun1=$this->CountFlightInternal();
        foreach($ArrResFun1 as $key => $row){
            $ArrCountFlightInternal[$row['client_id']]=$row['Count'];

        }

        $ArrResFun2=$this->CountFlightInternalgGBF();

        foreach($ArrResFun2 as $key => $row){
            if(!isset($ArrCountFlightInternalgGBF[$row['client_id']]))
                $ArrCountFlightInternalgGBF[$row['client_id']]=0;
            $ArrCountFlightInternalgGBF[$row['client_id']]++;

        }

        $ArrResFun3=$this->CountFlightForeigner();
        foreach($ArrResFun3 as $key => $row){
            $ArrCountFlightForeigner[$row['client_id']]=$row['Count'];
        }

        $ArrResFun4=$this->CountFlightForeignerGBF();
        foreach($ArrResFun4 as $key => $row){
            if(!isset($ArrCountFlightInternalgGBF[$row['client_id']]))
                $ArrCountFlightForeignerGBF[$row['client_id']]=0;
            $ArrCountFlightForeignerGBF[$row['client_id']]++;
        }


        $ArrResFun5=$this->CountTourInternal();
        foreach($ArrResFun5 as $key => $row){
            $ArrCountTourInternal[$row['client_id']]=$row['Count'];
        }


        $ArrResFun6=$this->CountTourInternalGBF();

        foreach($ArrResFun6 as $key => $row){
            if(!isset($ArrCountTourInternalGBF[$row['client_id']]))
                $ArrCountTourInternalGBF[$row['client_id']]=0;
            $ArrCountTourInternalGBF[$row['client_id']]++;
        }

        $ArrResFun7=$this->CountTourForeigner();
        foreach($ArrResFun7 as $key => $row){
            $ArrCountTourForeigner[$row['client_id']]=$row['Count'];
        }

        $ArrResFun8=$this->CountTourForeignerGBF();
        foreach($ArrResFun8 as $key => $row){
            if(!isset($ArrCountTourForeignerGBF[$row['client_id']]))
                $ArrCountTourForeignerGBF[$row['client_id']]=0;
            $ArrCountTourForeignerGBF[$row['client_id']]++;
        }

        $ArrResFun9=$this->CountHotelInternal();
        foreach($ArrResFun9 as $key => $row){
            $ArrCountHotelInternal[$row['client_id']]=$row['Count'];
        }

        $ArrResFun10=$this->CountHotelInternalGBF();
        foreach($ArrResFun10 as $key => $row){
            if(!isset($ArrCountHotelInternalGBF[$row['client_id']]))
                $ArrCountHotelInternalGBF[$row['client_id']]=0;
            $ArrCountHotelInternalGBF[$row['client_id']]++;
        }

        $ArrResFun11=$this->CountHotelForeigner();
        foreach($ArrResFun11 as $key => $row){
            $ArrCountHotelForeigner[$row['client_id']]=$row['Count'];
        }

        $ArrResFun12=$this->CountHotelForeignerGBF();
        foreach($ArrResFun12 as $key => $row){
            if(!isset($ArrCountHotelForeignerGBF[$row['client_id']]))
                $ArrCountHotelForeignerGBF[$row['client_id']]=0;
            $ArrCountHotelForeignerGBF[$row['client_id']]++;
        }

        $ArrResFun13=$this->CountTrain();
        foreach($ArrResFun13 as $key => $row){
            $ArrCountTrain[$row['client_id']]=$row['Count'];
        }

        $ArrResFun14=$this->CountTrainGBF();
        foreach($ArrResFun14 as $key => $row){
            if(!isset($ArrCountTrainGBF[$row['client_id']]))
                $ArrCountTrainGBF[$row['client_id']]=0;
            $ArrCountTrainGBF[$row['client_id']]++;
        }

        $ArrResFun15=$this->CountBus();
        foreach($ArrResFun15 as $key => $row){
            $ArrCountBus[$row['client_id']]=$row['Count'];
        }

        $ArrResFun16=$this->CountVisa();
        foreach($ArrResFun16 as $key => $row){
            $ArrCountVisa[$row['client_id']]=$row['Count'];
        }

        $ArrResFun17=$this->CountVisaGBF();
        foreach($ArrResFun17 as $key => $row){
            if(!isset($ArrCountVisaGBF[$row['client_id']]))
                $ArrCountVisaGBF[$row['client_id']]=0;
            $ArrCountVisaGBF[$row['client_id']]++;
        }

        $ArrResFun18=$this->CountInsurance();
        foreach($ArrResFun18 as $key => $row){
            $ArrCountInsurance[$row['client_id']]=$row['Count'];
        }

        $ArrResFun19=$this->CountInsuranceGBF();
        foreach($ArrResFun19 as $key => $row){
            if(!isset($ArrCountInsuranceGBF[$row['client_id']]))
                $ArrCountInsuranceGBF[$row['client_id']]=0;
            $ArrCountInsuranceGBF[$row['client_id']]++;
        }


        foreach($this->arr_Client as $key => $Client){

            $CountFlightInternal= $ArrCountFlightInternal[$Client['ClientId']];
            $CountFlightInternalGBF= $ArrCountFlightInternalgGBF[$Client['ClientId']];
            $CountFlightForeigner= $ArrCountFlightForeigner[$Client['ClientId']];
            $CountFlightForeignerGBF= $ArrCountFlightForeignerGBF[$Client['ClientId']];

            $CountTourInternal= $ArrCountTourInternal[$Client['ClientId']];
            $CountTourInternalGBF= $ArrCountTourInternalGBF[$Client['ClientId']];
            $CountTourForeigner= $ArrCountTourForeigner[$Client['ClientId']];
            $CountTourForeignerGBF= $ArrCountTourForeignerGBF[$Client['ClientId']];

            $CountHotelInternal= $ArrCountHotelInternal[$Client['ClientId']];
            $CountHotelInternalGBF= $ArrCountHotelInternalGBF[$Client['ClientId']];
            $CountHotelForeigner= $ArrCountHotelForeigner[$Client['ClientId']];
            $CountHotelForeignerGBF= $ArrCountHotelForeignerGBF[$Client['ClientId']];

            $CountTrain= $ArrCountTrain[$Client['ClientId']];
            $CountTrainGBF= $ArrCountTrainGBF[$Client['ClientId']];

            $CountBus= $ArrCountBus[$Client['ClientId']];

            $CountVisa= $ArrCountVisa[$Client['ClientId']];
            $CountVisaGBF= $ArrCountVisaGBF[$Client['ClientId']];

            $CountInsurance= $ArrCountInsurance[$Client['ClientId']];
            $CountInsuranceGBF= $ArrCountInsuranceGBF[$Client['ClientId']];

            $Arr_CountSales[$this->IndexArrOutAjax]['Information']=$Client;
            $Arr_CountSales[$this->IndexArrOutAjax]['Count']=array(
                'FlightInternal'=>$CountFlightInternal,
                'FlightForeigner'=>$CountFlightForeigner,
                'TourInternal'=>$CountTourInternal,
                'TourForeigner'=>$CountTourForeigner,
                'HotelInternal'=>$CountHotelInternal,
                'HotelForeigner'=>$CountHotelForeigner,
                'Train'=>$CountTrain,
                'Bus'=>$CountBus,
                'Visa'=>$CountVisa,
                'Insurance'=>$CountInsurance,


                'FlightInternalGBF'=>$CountFlightInternalGBF,
                'FlightForeignerGBF'=>$CountFlightForeignerGBF,
                'TourInternalGBF'=>$CountTourInternalGBF,
                'TourForeignerGBF'=>$CountTourForeignerGBF,
                'HotelInternalGBF'=>$CountHotelInternalGBF,
                'HotelForeignerGBF'=>$CountHotelForeignerGBF,
                'TrainGBF'=>$CountTrainGBF,
                'VisaGBF'=>$CountVisaGBF,
                'InsuranceGBF'=>$CountInsuranceGBF,
                'TotalSuccess' =>
                    intval($CountFlightInternalGBF) +
                    intval($CountFlightForeignerGBF) +
                    intval($CountTourInternalGBF) +
                    intval($CountTourForeignerGBF) +
                    intval($CountHotelInternalGBF) +
                    intval($CountHotelForeignerGBF) +
                    intval($CountTrainGBF) +
                    intval($CountVisaGBF) +
                    intval($CountInsuranceGBF) +
                    intval($CountBus)
            );

           // $this->OutAjax($Arr_CountSales[$this->IndexArrOutAjax]);
            array_push($this->result,$Arr_CountSales[$this->IndexArrOutAjax]);




            $this->IndexArrOutAjax++;

            $TotalFlightInternalGBF+=$CountFlightInternalGBF;
            $TotalFlightForeignerGBF+=$CountFlightForeignerGBF;
            $TotalTourInternalGBF+=$CountTourInternalGBF;
            $TotalTourForeignerGBF+=$CountTourForeignerGBF;
            $TotalHotelInternalGBF+=$CountHotelInternalGBF;
            $TotalHotelForeignerGBF+=$CountHotelForeignerGBF;
            $TotalTrainGBF+=$CountTrainGBF;
            $TotalBus+=$CountBus;
            $TotalVisaGBF+=$CountVisaGBF;
            $TotalInsuranceGBF+=$CountInsuranceGBF;
        }



        $Arr_ShowListSalesAgency['SumOfColumn']=array(
            'FlightInternalGBF'=>$TotalFlightInternalGBF,
            'FlightForeignerGBF'=>$TotalFlightForeignerGBF,
            'TourInternalGBF'=>$TotalTourInternalGBF,
            'TourForeignerGBF'=>$TotalTourForeignerGBF,
            'HotelInternalGBF'=>$TotalHotelInternalGBF,
            'HotelForeignerGBF'=>$TotalHotelForeignerGBF,
            'TrainGBF'=>$TotalTrainGBF,
            'Bus'=>$TotalBus,
            'VisaGBF'=>$TotalVisaGBF,
            'InsuranceGBF'=>$TotalInsuranceGBF,
            'successPayment' =>
                intval($TotalFlightInternalGBF) +
                intval($TotalFlightForeignerGBF) +
                intval($TotalTourInternalGBF) +
                intval($TotalTourForeignerGBF) +
                intval($TotalHotelInternalGBF) +
                intval($TotalHotelForeignerGBF) +
                intval($TotalTrainGBF) +
                intval($TotalBus) +
                intval($TotalVisaGBF) +
                intval($TotalInsuranceGBF)
        );
        array_unshift($this->result,$Arr_ShowListSalesAgency);
        //$this->EndTrOutAjax($Arr_ShowListSalesAgency);
        return json_encode($this->result);
        //return $this->HtmlOutAjax;

    }

	public function OutAjax($OutAjax){

        $Text1=$Text2=$Text3=$Text4=$Text5=$Text6=$Text7=$Text8=$Text9=$Text10=$Text11=0;

			if($OutAjax['Count']['FlightInternalGBF']>0)
				$Text1=$OutAjax['Count']['FlightInternal']." / ".$OutAjax['Count']['FlightInternalGBF'];
			if($OutAjax['Count']['FlightForeignerGBF']>0)
				$Text2=$OutAjax['Count']['FlightForeigner']." / ".$OutAjax['Count']['FlightForeignerGBF'];
			if($OutAjax['Count']['TourInternalGBF']>0)
				$Text3=$OutAjax['Count']['TourInternal']." / ".$OutAjax['Count']['TourInternalGBF'];
			if($OutAjax['Count']['TourForeignerGBF']>0)
				$Text4=$OutAjax['Count']['TourForeigner']." / ".$OutAjax['Count']['TourForeignerGBF'];
			if($OutAjax['Count']['HotelInternalGBF']>0)
				$Text5=$OutAjax['Count']['HotelInternal']." / ".$OutAjax['Count']['HotelInternalGBF'];
			if($OutAjax['Count']['HotelForeignerGBF']>0)
				$Text6=$OutAjax['Count']['HotelForeigner']." / ".$OutAjax['Count']['HotelForeignerGBF'];
			if($OutAjax['Count']['TrainGBF']>0)
				$Text7=$OutAjax['Count']['Train']." / ".$OutAjax['Count']['TrainGBF'];
			if($OutAjax['Count']['Bus']>0)
				$Text8=$OutAjax['Count']['Bus'];
			if($OutAjax['Count']['VisaGBF']>0)
				$Text9=$OutAjax['Count']['Visa']." / ".$OutAjax['Count']['VisaGBF'];
			if($OutAjax['Count']['InsuranceGBF']>0)
				$Text10=$OutAjax['Count']['Insurance']." / ".$OutAjax['Count']['InsuranceGBF'];
            if ($OutAjax['Count']['TotalSuccess']>0)
                $Text11 = $OutAjax['Count']['TotalSuccess'];

			$this->HtmlOutAjax.="
				<tr>
					<td>".$this->IndexHtml."</td>
					<td>".$OutAjax['Information']['NameAgency']."<br>".$OutAjax['Information']['Manager']."</td>
					<td>".$Text1."</td>
					<td>".$Text2."</td>
					<td>".$Text3."</td>
					<td>".$Text4."</td>
					<td>".$Text5."</td>
					<td>".$Text6."</td>
					<td>".$Text7."</td>
					<td>".$Text8."</td>
					<td>".$Text9."</td>
					<td>".$Text10."</td>
					<td>".$Text11."</td>
				</tr>
			";

			$this->IndexHtml++;
		//end if
	}//end fun

	public function EndTrOutAjax($EndTrOutAjax){
		$this->HtmlOutAjax.="
			<tr>
				<td></td>
				<td>جمع کل قراردادها نه افراد</td>
				<td>".$EndTrOutAjax['SumOfColumn']['FlightInternalGBF']."</td>
				<td>".$EndTrOutAjax['SumOfColumn']['FlightForeignerGBF']."</td>
				<td>".$EndTrOutAjax['SumOfColumn']['TourInternalGBF']."</td>
				<td>".$EndTrOutAjax['SumOfColumn']['TourForeignerGBF']."</td>
				<td>".$EndTrOutAjax['SumOfColumn']['HotelInternalGBF']."</td>
				<td>".$EndTrOutAjax['SumOfColumn']['HotelForeignerGBF']."</td>
				<td>".$EndTrOutAjax['SumOfColumn']['TrainGBF']."</td>
				<td>".$EndTrOutAjax['SumOfColumn']['Bus']."</td>
				<td>".$EndTrOutAjax['SumOfColumn']['VisaGBF']."</td>
				<td>".$EndTrOutAjax['SumOfColumn']['InsuranceGBF']."</td>
				<td>".$EndTrOutAjax['SumOfColumn']['successPayment']."</td>
			
			</tr>
		";
	}//end fun	
    public function CountFlightInternal(){
		$model = $this->getModel('reportModel');
        $result = $model->get("client_id,count(report_tb.id) as Count",true);
		$result->where('successfull','book');
		$result->where('del','no');
		$result->where('IsInternal','1');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('client_id');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun

	public function CountFlightInternalgGBF(){//GroupByFactor
		$model = $this->getModel('reportModel');
        $result = $model->get("client_id,count(report_tb.id) as Count",true);
		$result->where('successfull','book');
		$result->where('del','no');
		$result->where('IsInternal','1');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('factor_number');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun
	
    public function CountFlightForeigner(){	
		$model = $this->getModel('reportModel');
        $result = $model->get("client_id,count(report_tb.id) as Count",true);
		$result->where('successfull','book');
		$result->where('del','no');
		$result->where('IsInternal','1','!=');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('client_id');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun

    public function CountFlightForeignerGBF(){//GroupByFactor
		$model = $this->getModel('reportModel');
        $result = $model->get("client_id,count(report_tb.id) as Count",true);
		$result->where('successfull','book');
		$result->where('del','no');
		$result->where('IsInternal','1','!=');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('factor_number');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun
	
    public function CountTourInternal(){	
		$model = $this->getModel('reportTourModel');
        $result = $model->get("client_id,count(report_tour_tb.id) as Count",true);
		$result->where('status','BookedSuccessfully');
		$result->where('tour_origin_country_id ','1');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('client_id');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun
	
	public function CountTourInternalGBF(){//GroupByFactor	
		$model = $this->getModel('reportTourModel');
        $result = $model->get("client_id,count(report_tour_tb.id) as Count",true);
		$result->where('status','BookedSuccessfully');
		$result->where('tour_origin_country_id ','1');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('factor_number');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun

    public function CountTourForeigner(){
		$model = $this->getModel('reportTourModel');
        $result = $model->get("client_id,count(report_tour_tb.id) as Count",true);
		$result->where('status','BookedSuccessfully');
		$result->where('tour_origin_country_id ','1','!=');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('client_id');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun
	
	public function CountTourForeignerGBF(){//GroupByFactor
		$model = $this->getModel('reportTourModel');
        $result = $model->get("client_id,count(report_tour_tb.id) as Count",true);
		$result->where('status','BookedSuccessfully');
		$result->where('tour_origin_country_id ','1','!=');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('factor_number');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun
	
    public function CountHotelInternal(){		
		$model = $this->getModel('reportHotelModel');
        $result = $model->get("client_id,count(report_hotel_tb.id) as Count",true);
		$result->where('status','BookedSuccessfully');
		$result->where('isInternal ','1');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('client_id');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun
	
	public function CountHotelInternalGBF(){//GroupByFactor		
		$model = $this->getModel('reportHotelModel');
        $result = $model->get("client_id,count(report_hotel_tb.id) as Count",true);
		$result->where('status','BookedSuccessfully');
		$result->where('isInternal ','1');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('factor_number');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun
	
    public function CountHotelForeigner(){		
		$model = $this->getModel('reportHotelModel');
        $result = $model->get("client_id,count(report_hotel_tb.id) as Count",true);
		$result->where('status','BookedSuccessfully');
		$result->where('isInternal ','1','!=');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('client_id');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun
	
	 public function CountHotelForeignerGBF(){//GroupByFactor		
		$model = $this->getModel('reportHotelModel');
        $result = $model->get("client_id,count(report_hotel_tb.id) as Count",true);
		$result->where('status','BookedSuccessfully');
		$result->where('isInternal ','1','!=');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('factor_number');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun
	
    public function CountTrain(){		
		$model = $this->getModel('reportTrainModel');
        $result = $model->get("client_id,count(report_train_tb.id) as Count",true);
		$result->where('successfull','book');
		$result->where('del','no');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('client_id');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun
	
	public function CountTrainGBF(){//GroupByFactor		
		$model = $this->getModel('reportTrainModel');
        $result = $model->get("client_id,count(report_train_tb.id) as Count",true);
		$result->where('successfull','book');
		$result->where('del','no');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('factor_number');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun
	
    public function CountBus(){		
		$model = $this->getModel('reportBusModel');
        $result = $model->get("client_id,count(report_bus_tb.id) as Count",true);
		$result->where('status','book');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('client_id');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun

    public function CountVisa(){	
		$model = $this->getModel('reportVisaModel');
        $result = $model->get("client_id,count(report_visa_tb.id) as Count",true);
		$result->where('status','book');
		$result->where('del','no');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('client_id');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun

    public function CountVisaGBF(){//GroupByFactor	
		$model = $this->getModel('reportVisaModel');
        $result = $model->get("client_id,count(report_visa_tb.id) as Count",true);
		$result->where('status','book');
		$result->where('del','no');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('factor_number');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun
	
    public function CountInsurance(){	
		$model = $this->getModel('reportInsuranceModel');
        $result = $model->get("client_id,count(report_insurance_tb.id) as Count",true);
		$result->where('status','book');
		$result->where('del','no');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('client_id');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end fun

    public function CountInsuranceGBF(){//GroupByFactor	
		$model = $this->getModel('reportInsuranceModel');
        $result = $model->get("client_id,count(report_insurance_tb.id) as Count",true);
		$result->where('status','book');
		$result->where('del','no');
		$result->where('creation_date_int',$this->date_int_start, '>=');
		$result->where('creation_date_int',$this->date_int_end, '<=');
		$result->groupBy('factor_number');
		$sql = $result->toSql();
		$results = $result->all();
		return $results;
    }//end function
	
    public function ErrorJson($message){
        $resultJsonArray = array(
            'Result' => array(
                'RequestStatus' => 'Error',
                'Message'       => $message,
                'MessageCode'   => 'Error100',
            )
        );
        echo  json_encode( $resultJsonArray );die();
    }//end fun

}