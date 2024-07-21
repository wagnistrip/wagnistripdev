<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\OrderHotels;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Hotel\Amadeus\HeaderController;
use App\Models\HotelAddPaymentDetails;
use App\Models\MailSenders;
use App\Models\PaymentHotels;
use App\Models\PaymentHotelsBuzz;
use App\Models\TicketData;



class PaymentController extends Controller {
    public function createBuzz(Request $request)
    {
        $input = $request->all();
        //  dd($input);
        
        ////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////
        $saveData = new PaymentHotelsBuzz;
        $saveData->name_on_card = $request['name_on_card'];
        $saveData->bank_ref_num = $request['bank_ref_num'];
        $saveData->udf3 = $request['udf3'];
        $saveData->hash = $request['hash'];
        $saveData->firstname = $request['firstname'];
        $saveData->net_amount_debit = $request['net_amount_debit'];
        $saveData->payment_source = $request['payment_source'];
        $saveData->surl = $request['surl'];
        $saveData->error_Message = $request['error_Message'];
        $saveData->issuing_bank = $request['issuing_bank'];
        $saveData->cardCategory = $request['cardCategory'];
        $saveData->phone = $request['phone'];
        $saveData->easepayid = $request['easepayid'];
        $saveData->cardnum = $request['cardnum'];

        $saveData->key = $request['key'];
        $saveData->udf8 = $request['udf8'];
        $saveData->unmappedstatus = $request['unmappedstatus'];
        $saveData->PG_TYPE = $request['PG_TYPE'];
        $saveData->addedon = $request['addedon'];
        $saveData->cash_back_percentage = $request['cash_back_percentage'];
        $saveData->status = $request['status'];
        $saveData->card_type = $request['card_type'];
        $saveData->merchant_logo = $request['merchant_logo'];
        $saveData->udf6 = $request['udf6'];
        $saveData->udf10 = $request['udf10'];
        $saveData->upi_va = $request['upi_va'];
        $saveData->txnid = $request['txnid'];
        $saveData->productinfo = $request['productinfo'];
        $saveData->bank_name = $request['bank_name'];
        $saveData->furl = $request['furl'];
        $saveData->udf1 = $request['udf1'];
        $saveData->amount = $request['amount'];
        $saveData->udf2 = $request['udf2'];
        $saveData->udf5 = $request['udf5'];
        $saveData->mode = $request['mode'];
        $saveData->udf7 = $request['udf7'];

        $saveData->error = $request['error'];
        $saveData->udf9 = $request['udf9'];
        $saveData->bankcode = $request['bankcode'];
        $saveData->deduction_percentage = $request['deduction_percentage'];
        $saveData->email = $request['email'];
        $saveData->udf4 = $request['udf4'];
        ////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////

        $saveData->save();
        if($request['status'] !='success' ){
            $errorMsg = "Payment failed";
            return redirect()->route('error')->with('msg', $errorMsg);
        }
        
        $WTID = $request['udf1'];
        $datas = $request->all();
        $data = DB::table('paymentdatas')->where('id', '=', $request['udf1'])->get()->first();
        $adultTitle = explode(" | ", $data->adultTitle);
        $adultFirstName = explode(" | ", $data->adultFirstName);
        $adultLastName = explode(" | ", $data->adultLastName);
        
        // dd($input , $data);
        $personXML = '';
        $adultlen = count($adultTitle) - 1;
        $i = 0;
        while ($i < $adultlen) {
            // $personXML .= '<traveller><surname>'.$adultLastName[$i].'</surname><quantity>1</quantity></traveller><passenger><firstName>'.$adultFirstName[$i].'</firstName></passenger>';
            $personXML .= '<travellerInfo><elementManagementPassenger><reference><qualifier>PR</qualifier><number>1</number></reference><segmentName>NM</segmentName></elementManagementPassenger><passengerData><travellerInformation><traveller><surname>' . $adultLastName[$i] . '</surname><quantity>1</quantity></traveller><passenger><firstName>' . $adultFirstName[$i] . '</firstName></passenger></travellerInformation></passengerData></travellerInfo>';
            $i++;
        }
        // dd($adultLastName , $adultTitle, $adultFirstName , $personXML , $i);
        
        $payModel = new HotelAddPaymentDetails;
        $payModel->address = $data->address;
        $payModel->hotelname = $data->HotelName;
        $payModel->check = $data->checkin . ' | ' . $data->checkout;
        $payModel->adult = $data->adult;
        $payModel->name = $data->adultFirstName . $data->adultLastName;
        $payModel->phone = $data->phoneNumber;
        $payModel->email = $data->email;
        $payModel->amount =  $request['amount'];
        // $payModel->amount = $request->orderAmount;
        $payModel->uniqueid = "MMTHOTEL" . rand(1, 1000);
        $payModel->payment_id = $request['txnid'];
        $payModel->booking_code = $request['txnid'];
        $payModel->save();
        
        
        $action = "PNRADD_17_1_1A";
        $header = json_decode($data->header);
        $xml = '';
        $xml .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sec="http://xml.amadeus.com/2010/06/Security_v1" xmlns:typ="http://xml.amadeus.com/2010/06/Types_v1" xmlns:iat="http://www.iata.org/IATA/2007/00/IATA2010.1" xmlns:app="http://xml.amadeus.com/2010/06/AppMdw_CommonTypes_v3" xmlns:link="http://wsdl.amadeus.com/2010/06/ws/Link_v1" xmlns:ses="http://xml.amadeus.com/2010/06/Session_v3" xmlns:pnr="http://xml.amadeus.com/PNRADD_14_1_1A">';
        $xml .= HeaderController::headerInSeries($action, $header);
        $xml .= '<soapenv:Body>';
        $xml .= '<PNR_AddMultiElements xmlns="http://xml.amadeus.com/PNRADD_17_1_1A">';
        $xml .= '<pnrActions>';
        $xml .= '<optionCode>0</optionCode>';
        $xml .= '</pnrActions>';
        // $xml .= '<travellerInfo>';
        // $xml .= '<elementManagementPassenger>';
        // $xml .= '<reference>';
        // $xml .= '<qualifier>PR</qualifier>';
        // $xml .= '<number>1</number>';
        // $xml .= '</reference>';
        // $xml .= '<segmentName>NM</segmentName>';
        // $xml .= '</elementManagementPassenger>';
        // $xml .= '<passengerData>';
        // $xml .= '<travellerInformation>';
        // $xml .= '<traveller>';
        // $xml .= '<surname>'. $data->adultLastName.'</surname>';
        // $xml .= '<quantity>1</quantity>';
        // $xml .= '</traveller>';
        // $xml .= '<passenger>';
        // $xml .= '<firstName>'. $data->adultFirstName.'</firstName>';
        // $xml .= '</passenger>';
        $xml .= $personXML;
        // $xml .= '</travellerInformation>';
        // $xml .= '</passengerData>';
        // $xml .= '</travellerInfo>';
        $xml .= '<dataElementsMaster>';
        $xml .= '<marker1/>';
        $xml .= '<dataElementsIndiv>';
        $xml .= '<elementManagementData>';
        $xml .= '<segmentName>RM</segmentName>';
        $xml .= '</elementManagementData>';
        $xml .= '<miscellaneousRemark>';
        $xml .= '<remarks>';
        $xml .= '<type>RM</type>';
        $xml .= '<freetext>WAGNISTRIP PRIVATE LIMITED.(OPC)</freetext>';
        $xml .= '</remarks>';
        $xml .= '</miscellaneousRemark>';
        $xml .= '</dataElementsIndiv>';
        $xml .= '<dataElementsIndiv>';
        $xml .= '<elementManagementData>';
        $xml .= '<reference>';
        $xml .= '<qualifier>OT</qualifier>';
        $xml .= '<number>3</number>';
        $xml .= '</reference>';
        $xml .= '<segmentName>RF</segmentName>';
        $xml .= '</elementManagementData>';
        $xml .= '<freetextData>';
        $xml .= '<freetextDetail>';
        $xml .= '<subjectQualifier>3</subjectQualifier>';
        $xml .= '<type>3</type>';
        $xml .= '</freetextDetail>';
        $xml .= '<longFreetext>' . $data->email . '</longFreetext>';
        $xml .= '</freetextData>';
        $xml .= '</dataElementsIndiv>';
        $xml .= '<dataElementsIndiv>';
        $xml .= '<elementManagementData>';
        $xml .= '<reference>';
        $xml .= '<qualifier>OT</qualifier>';
        $xml .= '<number>3</number>';
        $xml .= '</reference>';
        $xml .= '<segmentName>TK</segmentName>';
        $xml .= '</elementManagementData>';
        $xml .= '<ticketElement>';
        $xml .= '<ticket>';
        $xml .= '<indicator>OK</indicator>';
        $xml .= '<date>' . date("dmy") . '</date>';
        $xml .= '</ticket>';
        $xml .= '</ticketElement>';
        $xml .= '</dataElementsIndiv>';
        $xml .= '<dataElementsIndiv>';
        $xml .= '<elementManagementData>';
        $xml .= '<reference>';
        $xml .= '<qualifier>OT</qualifier>';
        $xml .= '<number>3</number>';
        $xml .= '</reference>';
        $xml .= '<segmentName>AP</segmentName>';
        $xml .= '</elementManagementData>';
        $xml .= '<freetextData>';
        $xml .= '<freetextDetail>';
        $xml .= '<subjectQualifier>3</subjectQualifier>';
        $xml .= '<type>3</type>';
        $xml .= '</freetextDetail>';
        $xml .= '<longFreetext>' . $data->phoneNumber . '</longFreetext>';
        $xml .= '</freetextData>';
        $xml .= '</dataElementsIndiv>';
        $xml .= '</dataElementsMaster>';
        $xml .= '</PNR_AddMultiElements>';
        $xml .= '</soapenv:Body>';
        $xml .= '</soapenv:Envelope>';
        // dd($xml);
        
        $result = HeaderController::xmlCallWithBodyAndHeader2($xml, "PNRADD_17_1_1A_0");

        $detail = $result['body'];
        $headerSell = json_encode($result['header']['awsseSession'], true);
        $headerSell = json_decode($headerSell);
        // dd($detail);
        $actionSell = "HBKRCQ_17_1_1A";
        $xmlsell = '';
        $xmlsell .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sec="http://xml.amadeus.com/2010/06/Security_v1" xmlns:typ="http://xml.amadeus.com/2010/06/Types_v1" xmlns:iat="http://www.iata.org/IATA/2007/00/IATA2010.1" xmlns:app="http://xml.amadeus.com/2010/06/AppMdw_CommonTypes_v3" xmlns:link="http://wsdl.amadeus.com/2010/06/ws/Link_v1" xmlns:ses="http://xml.amadeus.com/2010/06/Session_v3" xmlns:hbk="http://xml.amadeus.com/HBKRCQ_13_2_1A">';
        $xmlsell .= HeaderController::headerInSeries($actionSell, $headerSell);
        $xmlsell .= '<soapenv:Body>';
        $xmlsell .= '<Hotel_Sell xmlns="http://xml.amadeus.com/HBKRCQ_17_1_1A">';
        $xmlsell .= '<roomStayData>';
        $xmlsell .= '<markerRoomStayData></markerRoomStayData>';
        $xmlsell .= '<globalBookingInfo>';
        $xmlsell .= '<markerGlobalBookingInfo></markerGlobalBookingInfo>';
        $xmlsell .= '<bookingSource>';
        $xmlsell .= '<originIdentification>';
        $xmlsell .= '<originatorId>14385420</originatorId>';
        $xmlsell .= '</originIdentification>';
        $xmlsell .= '</bookingSource>';
        $xmlsell .= '<representativeParties>';
        $xmlsell .= '<occupantList>';
        $xmlsell .= '<passengerReference>';
        $xmlsell .= '<type>BHO</type>';
        $xmlsell .= '<value>2</value>';
        $xmlsell .= '</passengerReference>';
        $xmlsell .= '</occupantList>';
        $xmlsell .= '</representativeParties>';
        $xmlsell .= '</globalBookingInfo>';
        $xmlsell .= '<roomList>';
        $xmlsell .= '<markerRoomstayQuery></markerRoomstayQuery>';
        $xmlsell .= '<roomRateDetails>';
        $xmlsell .= '<marker></marker>';
        $xmlsell .= '<hotelProductReference>';
        $xmlsell .= '<referenceDetails>';
        $postvalue = $data;
        $xmlsell .= '<type>BC</type>';
        $xmlsell .= '<value>' . $data->booking_code . '</value>';
        $xmlsell .= '</referenceDetails>';
        $xmlsell .= '</hotelProductReference>';
        $xmlsell .= '<markerOfExtra></markerOfExtra>';
        $xmlsell .= '</roomRateDetails>';
        $xmlsell .= '<guaranteeOrDeposit>';
        $xmlsell .= '<paymentInfo>';
        $xmlsell .= '<paymentDetails>';
        $xmlsell .= '<formOfPaymentCode>1</formOfPaymentCode>';
        $xmlsell .= '<paymentType>1</paymentType>';
        $xmlsell .= '<serviceToPay>3</serviceToPay>';
        $xmlsell .= '</paymentDetails>';
        $xmlsell .= '</paymentInfo>';
        $xmlsell .= '<groupCreditCardInfo>';
        $xmlsell .= '<creditCardInfo>';
        $xmlsell .= '<ccInfo>';
        // /////////////////////////////////////////////////////////////////////
        // $xmlsell .= '<vendorCode>VI</vendorCode>';
        // $xmlsell .= '<cardNumber>4263982640269299</cardNumber>';
        // $xmlsell .= '<securityId>837</securityId>';
        // $xmlsell .= '<expiryDate>0224</expiryDate>';
        // $xmlsell .= '<ccHolderName>MAKETRUETRIP</ccHolderName>';
        ///////////////////////////////////////////////////////////////////
        // /////////////////////////////////////////////////////////////////////
        $xmlsell .= '<vendorCode>VI</vendorCode>';
        $xmlsell .= '<cardNumber>4102020364899002</cardNumber>';
        $xmlsell .= '<securityId>408</securityId>';
        $xmlsell .= '<expiryDate>0625</expiryDate>';
        $xmlsell .= '<ccHolderName>DEEPAK KHANNA</ccHolderName>';
        ///////////////////////////////////////////////////////////////////
        $xmlsell .= '</ccInfo>';
        $xmlsell .= '</creditCardInfo>';
        $xmlsell .= '</groupCreditCardInfo>';
        $xmlsell .= '</guaranteeOrDeposit>';
        $xmlsell .= '</roomList>';
        $xmlsell .= '</roomStayData>';
        $xmlsell .= '</Hotel_Sell>';
        $xmlsell .= '</soapenv:Body>';
        $xmlsell .= '</soapenv:Envelope>';
        $resultSell = HeaderController::xmlCallWithBodyAndHeader2($xmlsell, $actionSell);
        
        // dd($resultSell);
        $resultDetailBody = $resultSell['body'];
        $headerSell2 = json_encode($resultSell['header']['awsseSession'], true);
        $headerSell2 = json_decode($headerSell2);
        $actionRetrive = "PNRADD_17_1_1A";
        $xmlsellRetrive = '';
        $xmlsellRetrive .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sec="http://xml.amadeus.com/2010/06/Security_v1" xmlns:typ="http://xml.amadeus.com/2010/06/Types_v1" xmlns:iat="http://www.iata.org/IATA/2007/00/IATA2010.1" xmlns:app="http://xml.amadeus.com/2010/06/AppMdw_CommonTypes_v3" xmlns:link="http://wsdl.amadeus.com/2010/06/ws/Link_v1" xmlns:ses="http://xml.amadeus.com/2010/06/Session_v3" xmlns:pnr="http://xml.amadeus.com/PNRADD_17_1_1A">';
        $xmlsellRetrive .= HeaderController::headerInSeries($actionRetrive, $headerSell2);
        $xmlsellRetrive .= '<soapenv:Body>';
        $xmlsellRetrive .= '<PNR_AddMultiElements xmlns="http://xml.amadeus.com/PNRADD_17_1_1A">';
        $xmlsellRetrive .= '<pnrActions>';
        $xmlsellRetrive .= '<optionCode>10</optionCode>';
        $xmlsellRetrive .= '</pnrActions>';
        $xmlsellRetrive .= '<dataElementsMaster>';
        $xmlsellRetrive .= '<marker1 />';
        $xmlsellRetrive .= '<dataElementsIndiv>';
        $xmlsellRetrive .= '<elementManagementData>';
        $xmlsellRetrive .= '<segmentName>RM</segmentName>';
        $xmlsellRetrive .= '</elementManagementData>';
        $xmlsellRetrive .= '<miscellaneousRemark>';
        $xmlsellRetrive .= '<remarks>';
        $xmlsellRetrive .= '<type>RM</type>';
        $xmlsellRetrive .= '<freetext>WagnisTrip Pvt. Ltd.</freetext>';
        $xmlsellRetrive .= '</remarks>';
        $xmlsellRetrive .= '</miscellaneousRemark>';
        $xmlsellRetrive .= '</dataElementsIndiv>';
        $xmlsellRetrive .= '<dataElementsIndiv>';
        $xmlsellRetrive .= '<elementManagementData>';
        $xmlsellRetrive .= '<segmentName>RF</segmentName>';
        $xmlsellRetrive .= '</elementManagementData>';
        $xmlsellRetrive .= '<freetextData>';
        $xmlsellRetrive .= '<freetextDetail>';
        $xmlsellRetrive .= '<subjectQualifier>3</subjectQualifier>';
        // $xmlsellRetrive .= '<textSubjectQualifier>PAY</textSubjectQualifier>';
        $xmlsellRetrive .= '<type>P22</type>';
        $xmlsellRetrive .= '</freetextDetail>';
        $xmlsellRetrive .= '<longFreetext>BOOKIN IS VIP</longFreetext>';
        $xmlsellRetrive .= '</freetextData>';
        $xmlsellRetrive .= '</dataElementsIndiv>';
        $xmlsellRetrive .= '</dataElementsMaster>';
        $xmlsellRetrive .= '</PNR_AddMultiElements>';
        $xmlsellRetrive .= '</soapenv:Body>';
        $xmlsellRetrive .= '</soapenv:Envelope>';
        $resultSellRetrive = HeaderController::xmlCallWithBodyAndHeader2($xmlsellRetrive, "PNRADD_17_1_1A");
        $resultSellRetriveBody = $resultSellRetrive['body'];
        // uddeshya code error hendiling 
        if (!isset($resultSellRetriveBody['PNR_Reply']['pnrHeader']['reservationInfo']['reservation']['controlNumber'])) {
            $error = '';
            if (isset($resultSellRetriveBody['PNR_Reply']['generalErrorInfo']['errorWarningDescription']['freeText'])) {
                $arrary = $resultSellRetriveBody['PNR_Reply']['generalErrorInfo']['errorWarningDescription']['freeText'];

                // dd($resultSellRetrive ,  $resultSell);

                $arrLength = count($arrary);
                for ($i = 0; $i < $arrLength; $i++) {
                    $error .= $arrary[$i];
                }
            }
            return redirect()->route('error')->with('msg', 'Undefined index: controlNumber ' . $error);
        }
        // end uddeshya code 
        $controlNumber = $resultSellRetriveBody['PNR_Reply']['pnrHeader']['reservationInfo']['reservation']['controlNumber'];
        $headerSell3 = json_encode($resultSellRetrive['header']['awsseSession'], true);
        $headerSell3 = json_decode($headerSell3);
        // dd($headerSell3);
        $actionRetriveRepeat = "PNRRET_17_1_1A";
        $xmlsellRetriveRepeat = '';
        $xmlsellRetriveRepeat .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sec="http://xml.amadeus.com/2010/06/Security_v1" xmlns:typ="http://xml.amadeus.com/2010/06/Types_v1" xmlns:iat="http://www.iata.org/IATA/2007/00/IATA2010.1" xmlns:app="http://xml.amadeus.com/2010/06/AppMdw_CommonTypes_v3" xmlns:link="http://wsdl.amadeus.com/2010/06/ws/Link_v1" xmlns:ses="http://xml.amadeus.com/2010/06/Session_v3" xmlns:pnr="http://xml.amade us.com/PNRADD_17_1_1A">';
        $xmlsellRetriveRepeat .= HeaderController::headerInSeries($actionRetriveRepeat, $headerSell3);
        $xmlsellRetriveRepeat .= '<soapenv:Body>';
        $xmlsellRetriveRepeat .= '<PNR_Retrieve xmlns="http://xml.amadeus.com/PNRRET_17_1_1A">';
        $xmlsellRetriveRepeat .= '<retrievalFacts>';
        $xmlsellRetriveRepeat .= '<retrieve>';
        $xmlsellRetriveRepeat .= '<type>2</type>';
        $xmlsellRetriveRepeat .= '</retrieve>';
        $xmlsellRetriveRepeat .= '<reservationOrProfileIdentifier>';
        $xmlsellRetriveRepeat .= '<reservation>';
        $xmlsellRetriveRepeat .= '<controlNumber>' . $controlNumber . '</controlNumber>';
        $xmlsellRetriveRepeat .= '</reservation>';
        $xmlsellRetriveRepeat .= '</reservationOrProfileIdentifier>';
        $xmlsellRetriveRepeat .= '</retrievalFacts>';
        $xmlsellRetriveRepeat .= '</PNR_Retrieve>';
        $xmlsellRetriveRepeat .= '</soapenv:Body>';
        $xmlsellRetriveRepeat .= '</soapenv:Envelope>';
        $resultsellRetriveRepeat = HeaderController::xmlCallWithBodyAndHeader2($xmlsellRetriveRepeat, $actionRetriveRepeat);

        $xmlLogOut = '';
        $xmlLogOut .= '<Security_SignOut';
        $xmlLogOut .= ' xmlns="http://xml.amadeus.com/VLSSOQ_04_1_1A">';
        $xmlLogOut .= '</Security_SignOut>';
        // $logOutResponce =HeaderController::xmlCallWithBodyAndHeader2($xmlLogOut, $actionRetriveRepeat);
        // dd($logOutResponce);
        $MttID = 'WAGNIS' . $request->orderId;
        
        
        // dd($resultsellRetriveRepeat['body']['soapFault']);
        // dd($resultsellRetriveRepeat['body'] ,$resultsellRetriveRepeat['body']['soapFault']);
        // dd($resultsellRetriveRepeat);

        if (isset($resultsellRetriveRepeat['body'])) {
            isset($resultsellRetriveRepeat['body']['PNR_Reply']) ?
            $ticketData =  $resultsellRetriveRepeat['body']['PNR_Reply'] : $ticktData = $resultsellRetriveRepeat['body']['PNR_Reply'];
        } else {
            return redirect()->route('error')->with('msg', 'Control number error');
        }
        
        if (isset($ticketData['originDestinationDetails']['itineraryInfo'][0]['hotelReservationInfo']['hotelPropertyInfo']['hotelName'])) {
            $ticketDataVal = $ticketData['originDestinationDetails']['itineraryInfo'][0]['hotelReservationInfo']['hotelPropertyInfo']['hotelName'];
        } else {
            $ticketDataVal = $ticketData['originDestinationDetails']['itineraryInfo']['hotelReservationInfo']['hotelPropertyInfo']['hotelName'];
        }
        
        if (!isset($ticketData['originDestinationDetails']['itineraryInfo'][0]['hotelReservationInfo']['requestedDates'])) {
            $dates = $ticketData['originDestinationDetails']['itineraryInfo']['hotelReservationInfo']['requestedDates'];
        } else {
            $dates = $ticketData['originDestinationDetails']['itineraryInfo'][0]['hotelReservationInfo']['requestedDates'];
        }
        $dateStart = date_create($dates['beginDateTime']['year'] . '-' . $dates['beginDateTime']['month'] . '-' . $dates['beginDateTime']['day']);
        $dateEnd = date_create($dates['endDateTime']['year'] . '-' . $dates['endDateTime']['month'] . '-' . $dates['endDateTime']['day']);
        $diff = $dateEnd->diff($dateStart);
        $dayCount = $diff->format('%a');
        if (isset($ticketData['originDestinationDetails']['itineraryInfo'][0]['rateInformations']['ratePrice']['rateAmount'])) {
            $amountFare = $ticketData['originDestinationDetails']['itineraryInfo'][0]['rateInformations']['ratePrice']['rateAmount'] * $dayCount;
        } else {
            $amountFare = $ticketData['originDestinationDetails']['itineraryInfo']['rateInformations']['ratePrice']['rateAmount'] * $dayCount;
        }
        
        // $refno = $ticketData['pnrHeader']['reservationInfo']['reservation']['controlNumber'];
        // $mailSend = MailSender::where('refno', '=', $refno)->first();
        // {{-- if (!$mailSend) {
        //     $mailSend = $order = new MailSender;
        //     $order->email = $data->email;
        //     $order->amount = $request->orderAmount;
        //     $order->phone = $data->phoneNumber;
        //     $order->refno = $refno;
        //     $order->ismail = '1';
        //     $order->save();
            
        //     // dd($postvalue);
            
        //     $ticketData = new TicketData;
            
        //     $ticketData->BookRef = $refno;
        //     $ticketData->BookID = $WTID;
        //     $ticketData->TicVal = $ticketDataVal;
            
        //     $ticketData->adultTitle = $data->adultFirstName;
        //     $ticketData->adultFirstName = $data->adultLastName;
        //     $ticketData->adultLastName = $data->adultLastName;
            
        //     $ticketData->phoneNumber = $data->phoneNumber;
        //     $ticketData->email = $data->email;
            
        //     $ticketData->checkin = $data->checkin;
        //     $ticketData->checkout = $data->checkout;
        //     $ticketData->night = $dayCount;
            
        //     $ticketData->HotelName = $data->HotelName;
        //     $ticketData->address = $data->address;
            
        //     $ticketData->Price = number_format(round($amountFare));
        //     $ticketData->Taxes = number_format(round($postvalue->amount - $amountFare));
        //     $ticketData->Total = number_format(round($postvalue->amount));
        //     $ticketData->PayDet =  $request['orderId'];
            
        //     $ticketData->Adults = $postvalue->adult;
        //     if (isset($postvalue->child)) {
        //         $ticketData->Childs = $postvalue->child;
        //     }
        //     if (isset($postvalue->room)) {
        //         $ticketData->Rooms = $postvalue->room;
        //     } else {
        //         $ticketData->Rooms = '1';
        //     }
            
        //     $ticketData->save();
        //     $id = TicketData::orderBy('created_at', 'desc')->first();
        //     $id = $id['id'];
            
        //     $maildata = [
        //         'resultsellRetriveRepeat' => $resultsellRetriveRepeat,
        //         'postvalue' => $postvalue,
        //         'data' => $data,
        //         'email' => $data->email,
        //         'id' => $id
        //     ];
        //     MailController::bassendToCus($maildata);
        //     MailController::bassendToCus($maildata);
        // }
        
        // dd($resultsellRetriveRepeat , $postvalue , $data);
        
        return view('hotel-pages.ticket', compact('resultsellRetriveRepeat', 'postvalue', 'data', 'MttID'));
    }
    public function create(Request $request) {
        $order = new PaymentHotels;
        $order->order_amount= $request->orderAmount;
        $order->order_id=$request->orderId;
        $order->reference_id=$request->referenceId;
        $order->sign=$request->signature;
        $order->txMsg=$request->txMsg;
        $order->txStatus=$request->txStatus;
        $order->txtime=$request->txTime;
        $order->payment_mode=$request->paymentMode;
        $order->save();
        $MttID ='WT'. $request->orderId;
        if ($request->txStatus !='SUCCESS'){
            $errorMsg ="Some problem in payments";
            return redirect()->route('error')->with('msg', $errorMsg);
        }

        $datas = $request->all();
        $data =DB::table('paymentdatas')->where('id','like',$request->orderId)->get()->first();
        
        $adultTitle = explode (" | ", $data->adultTitle); 
        $adultFirstName = explode (" | ", $data->adultFirstName); 
        $adultLastName = explode (" | ", $data->adultLastName); 

        $personXML = '';
        $adultlen = count($adultTitle)-1;
        $i = 0;
        while ($i < $adultlen){
            // $personXML .= '<traveller><surname>'.$adultLastName[$i].'</surname><quantity>1</quantity></traveller><passenger><firstName>'.$adultFirstName[$i].'</firstName></passenger>';
            $personXML .= '<travellerInfo><elementManagementPassenger><reference><qualifier>PR</qualifier><number>1</number></reference><segmentName>NM</segmentName></elementManagementPassenger><passengerData><travellerInformation><traveller><surname>'.$adultLastName[$i].'</surname><quantity>1</quantity></traveller><passenger><firstName>'.$adultFirstName[$i].'</firstName></passenger></travellerInformation></passengerData></travellerInfo>';
            $i++;
        }
        // dd($adultLastName , $adultTitle, $adultFirstName , $personXML);
        // dd($request->orderId);
        // dd($data);
        $payModel = new HotelAddPaymentDetails;
        $payModel->address = $data->address;
        $payModel->hotelname = $data->HotelName;
        $payModel->check = $data->checkin.' | '.$data->checkout;
        $payModel->adult =$data->adult;
        $payModel->name = $data->adultFirstName.$data->adultLastName;
        $payModel->phone = $data->phoneNumber;
        $payModel->email =$data->email;
        $payModel->amount = $request->orderAmount;
        $payModel->uniqueid = "WTHOTEL".rand(1,1000);
        $payModel->payment_id = $request['orderId'];
        $payModel->booking_code = $request['orderId'];
        $payModel->save();
        

        $action = "PNRADD_17_1_1A";
        $header = json_decode($data->header);
        $xml = '';
        $xml .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sec="http://xml.amadeus.com/2010/06/Security_v1" xmlns:typ="http://xml.amadeus.com/2010/06/Types_v1" xmlns:iat="http://www.iata.org/IATA/2007/00/IATA2010.1" xmlns:app="http://xml.amadeus.com/2010/06/AppMdw_CommonTypes_v3" xmlns:link="http://wsdl.amadeus.com/2010/06/ws/Link_v1" xmlns:ses="http://xml.amadeus.com/2010/06/Session_v3" xmlns:pnr="http://xml.amadeus.com/PNRADD_14_1_1A">';
        $xml .= HeaderController::headerInSeries($action, $header);
        $xml .= '<soapenv:Body>';
        $xml .= '<PNR_AddMultiElements xmlns="http://xml.amadeus.com/PNRADD_17_1_1A">';
        $xml .= '<pnrActions>';
        $xml .= '<optionCode>0</optionCode>';
        $xml .= '</pnrActions>';
        $xml .= $personXML;
        // $xml .= '<travellerInfo>';
        // $xml .= '<elementManagementPassenger>';
        // $xml .= '<reference>';
        // $xml .= '<qualifier>PR</qualifier>';
        // $xml .= '<number>1</number>';
        // $xml .= '</reference>';
        // $xml .= '<segmentName>NM</segmentName>';
        // $xml .= '</elementManagementPassenger>';
        // $xml .= '<passengerData>';
        // $xml .= '<travellerInformation>';
        // $xml .= '<traveller>';
        // $xml .= '<surname>'. $data->adultLastName.'</surname>';
        // $xml .= '<quantity>1</quantity>';
        // $xml .= '</traveller>';
        // $xml .= '<passenger>';
        // $xml .= '<firstName>'. $data->adultFirstName.'</firstName>';
        // $xml .= '</passenger>';
        // $xml .= '</travellerInformation>';
        // $xml .= '</passengerData>';
        // $xml .= '</travellerInfo>';
        $xml .= '<dataElementsMaster>';
        $xml .= '<marker1/>';
        $xml .= '<dataElementsIndiv>';
        $xml .= '<elementManagementData>';
        $xml .= '<segmentName>RM</segmentName>';
        $xml .= '</elementManagementData>';
        $xml .= '<miscellaneousRemark>';
        $xml .= '<remarks>';
        $xml .= '<type>RM</type>';
        $xml .= '<freetext>WAGNISTRIP PRIVATE LIMITED.</freetext>';
        $xml .= '</remarks>';
        $xml .= '</miscellaneousRemark>';
        $xml .= '</dataElementsIndiv>';
        $xml .= '<dataElementsIndiv>';
        $xml .= '<elementManagementData>';
        $xml .= '<reference>';
        $xml .= '<qualifier>OT</qualifier>';
        $xml .= '<number>3</number>';
        $xml .= '</reference>';
        $xml .= '<segmentName>RF</segmentName>';
        $xml .= '</elementManagementData>';
        $xml .= '<freetextData>';
        $xml .= '<freetextDetail>';
        $xml .= '<subjectQualifier>3</subjectQualifier>';
        $xml .= '<type>3</type>';
        $xml .= '</freetextDetail>';
        $xml .= '<longFreetext>' . $data->email . '</longFreetext>';
        $xml .= '</freetextData>';
        $xml .= '</dataElementsIndiv>';
        $xml .= '<dataElementsIndiv>';
        $xml .= '<elementManagementData>';
        $xml .= '<reference>';
        $xml .= '<qualifier>OT</qualifier>';
        $xml .= '<number>3</number>';
        $xml .= '</reference>';
        $xml .= '<segmentName>TK</segmentName>';
        $xml .= '</elementManagementData>';
        $xml .= '<ticketElement>';
        $xml .= '<ticket>';
        $xml .= '<indicator>OK</indicator>';
        $xml .= '<date>' . date("dmy") . '</date>';
        $xml .= '</ticket>';
        $xml .= '</ticketElement>';
        $xml .= '</dataElementsIndiv>';
        $xml .= '<dataElementsIndiv>';
        $xml .= '<elementManagementData>';
        $xml .= '<reference>';
        $xml .= '<qualifier>OT</qualifier>';
        $xml .= '<number>3</number>';
        $xml .= '</reference>';
        $xml .= '<segmentName>AP</segmentName>';
        $xml .= '</elementManagementData>';
        $xml .= '<freetextData>';
        $xml .= '<freetextDetail>';
        $xml .= '<subjectQualifier>3</subjectQualifier>';
        $xml .= '<type>3</type>';
        $xml .= '</freetextDetail>';
        $xml .= '<longFreetext>'. $data->phoneNumber .'</longFreetext>';
        $xml .= '</freetextData>';
        $xml .= '</dataElementsIndiv>';
        $xml .= '</dataElementsMaster>';
        $xml .= '</PNR_AddMultiElements>';
        $xml .= '</soapenv:Body>';
        $xml .= '</soapenv:Envelope>';
        // dd($xml);
        
        $result = HeaderController::xmlCallWithBodyAndHeader2($xml, "PNRADD_17_1_1A_0");
        $detail = $result['body'];
        $headerSell = json_encode($result['header']['awsseSession'], true);
        $headerSell = json_decode($headerSell);
        // dd($detail);
        $actionSell = "HBKRCQ_17_1_1A";
        $xmlsell = '';
        $xmlsell .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sec="http://xml.amadeus.com/2010/06/Security_v1" xmlns:typ="http://xml.amadeus.com/2010/06/Types_v1" xmlns:iat="http://www.iata.org/IATA/2007/00/IATA2010.1" xmlns:app="http://xml.amadeus.com/2010/06/AppMdw_CommonTypes_v3" xmlns:link="http://wsdl.amadeus.com/2010/06/ws/Link_v1" xmlns:ses="http://xml.amadeus.com/2010/06/Session_v3" xmlns:hbk="http://xml.amadeus.com/HBKRCQ_13_2_1A">';
        $xmlsell .= HeaderController::headerInSeries($actionSell, $headerSell);
        $xmlsell .= '<soapenv:Body>';
        $xmlsell .= '<Hotel_Sell xmlns="http://xml.amadeus.com/HBKRCQ_17_1_1A">';
        $xmlsell .= '<roomStayData>';
        $xmlsell .= '<markerRoomStayData></markerRoomStayData>';
        $xmlsell .= '<globalBookingInfo>';
        $xmlsell .= '<markerGlobalBookingInfo></markerGlobalBookingInfo>';
        $xmlsell .= '<bookingSource>';
        $xmlsell .= '<originIdentification>';
        $xmlsell .= '<originatorId>14385420</originatorId>';
        $xmlsell .= '</originIdentification>';
        $xmlsell .= '</bookingSource>';
        $xmlsell .= '<representativeParties>';
        $xmlsell .= '<occupantList>';
        $xmlsell .= '<passengerReference>';
        $xmlsell .= '<type>BHO</type>';
        $xmlsell .= '<value>2</value>';
        $xmlsell .= '</passengerReference>';
        $xmlsell .= '</occupantList>';
        $xmlsell .= '</representativeParties>';
        $xmlsell .= '</globalBookingInfo>';
        $xmlsell .= '<roomList>';
        $xmlsell .= '<markerRoomstayQuery></+>';
        $xmlsell .= '<roomRateDetails>';
        $xmlsell .= '<marker></marker>';
        $xmlsell .= '<hotelProductReference>';
        $xmlsell .= '<referenceDetails>';
        $postvalue = $data;
        $xmlsell .= '<type>BC</type>';
        $xmlsell .= '<value>' . $data->booking_code . '</value>';
        $xmlsell .= '</referenceDetails>';
        $xmlsell .= '</hotelProductReference>';
        $xmlsell .= '<markerOfExtra></markerOfExtra>';
        $xmlsell .= '</roomRateDetails>';
        $xmlsell .= '<guaranteeOrDeposit>';
        $xmlsell .= '<paymentInfo>';
        $xmlsell .= '<paymentDetails>';
        $xmlsell .= '<formOfPaymentCode>1</formOfPaymentCode>';
        $xmlsell .= '<paymentType>1</paymentType>';
        $xmlsell .= '<serviceToPay>3</serviceToPay>';
        $xmlsell .= '</paymentDetails>';
        $xmlsell .= '</paymentInfo>';
        $xmlsell .= '<groupCreditCardInfo>';
        $xmlsell .= '<creditCardInfo>';
        $xmlsell .= '<ccInfo>';
        $xmlsell .= '<vendorCode>VI</vendorCode>';
        $xmlsell .= '<cardNumber>4102020364899002</cardNumber>';
        $xmlsell .= '<securityId>408</securityId>';
        $xmlsell .= '<expiryDate>0625</expiryDate>';
        $xmlsell .= '<ccHolderName>DEEPAK KHANNA</ccHolderName>';
        $xmlsell .= '</ccInfo>';
        $xmlsell .= '</creditCardInfo>';
        $xmlsell .= '</groupCreditCardInfo>';
        $xmlsell .= '</guaranteeOrDeposit>';
        $xmlsell .= '</roomList>';
        $xmlsell .= '</roomStayData>';
        $xmlsell .= '</Hotel_Sell>';
        $xmlsell .= '</soapenv:Body>';
        $xmlsell .= '</soapenv:Envelope>';
        $resultSell = HeaderController::xmlCallWithBodyAndHeader2($xmlsell, $actionSell);
        $resultDetailBody = $resultSell['body'];
        $headerSell2 = json_encode($resultSell['header']['awsseSession'], true);
        $headerSell2 = json_decode($headerSell2);
        $actionRetrive = "PNRADD_17_1_1A";
        $xmlsellRetrive = '';
        $xmlsellRetrive .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sec="http://xml.amadeus.com/2010/06/Security_v1" xmlns:typ="http://xml.amadeus.com/2010/06/Types_v1" xmlns:iat="http://www.iata.org/IATA/2007/00/IATA2010.1" xmlns:app="http://xml.amadeus.com/2010/06/AppMdw_CommonTypes_v3" xmlns:link="http://wsdl.amadeus.com/2010/06/ws/Link_v1" xmlns:ses="http://xml.amadeus.com/2010/06/Session_v3" xmlns:pnr="http://xml.amadeus.com/PNRADD_17_1_1A">';
        $xmlsellRetrive .= HeaderController::headerInSeries($actionRetrive, $headerSell2);
        $xmlsellRetrive .= '<soapenv:Body>';
        $xmlsellRetrive .= '<PNR_AddMultiElements xmlns="http://xml.amadeus.com/PNRADD_17_1_1A">';
        $xmlsellRetrive .= '<pnrActions>';
        $xmlsellRetrive .= '<optionCode>10</optionCode>';
        $xmlsellRetrive .= '</pnrActions>';
        $xmlsellRetrive .= '<dataElementsMaster>';
        $xmlsellRetrive .= '<marker1 />';
        $xmlsellRetrive .= '<dataElementsIndiv>';
        $xmlsellRetrive .= '<elementManagementData>';
        $xmlsellRetrive .= '<segmentName>RM</segmentName>';
        $xmlsellRetrive .= '</elementManagementData>';
        $xmlsellRetrive .= '<miscellaneousRemark>';
        $xmlsellRetrive .= '<remarks>';
        $xmlsellRetrive .= '<type>RM</type>';
        $xmlsellRetrive .= '<freetext>Wagnistrip (OPC) Pvt. Ltd.</freetext>';
        $xmlsellRetrive .= '</remarks>';
        $xmlsellRetrive .= '</miscellaneousRemark>';
        $xmlsellRetrive .= '</dataElementsIndiv>';
        $xmlsellRetrive .= '<dataElementsIndiv>';
        $xmlsellRetrive .= '<elementManagementData>';
        $xmlsellRetrive .= '<segmentName>RF</segmentName>';
        $xmlsellRetrive .= '</elementManagementData>';
        $xmlsellRetrive .= '<freetextData>';
        $xmlsellRetrive .= '<freetextDetail>';
        $xmlsellRetrive .= '<subjectQualifier>3</subjectQualifier>';
        $xmlsellRetrive .= '<type>P22</type>';
        $xmlsellRetrive .= '</freetextDetail>';
        $xmlsellRetrive .= '<longFreetext>BOOKIN IS VIP</longFreetext>';
        $xmlsellRetrive .= '</freetextData>';
        $xmlsellRetrive .= '</dataElementsIndiv>';
        $xmlsellRetrive .= '</dataElementsMaster>';
        $xmlsellRetrive .= '</PNR_AddMultiElements>';
        $xmlsellRetrive .= '</soapenv:Body>';
        $xmlsellRetrive .= '</soapenv:Envelope>';
        $resultSellRetrive = HeaderController::xmlCallWithBodyAndHeader2($xmlsellRetrive, "PNRADD_17_1_1A");
        $resultSellRetriveBody = $resultSellRetrive['body'];
        // uddeshya code error hendiling 
        if(!isset($resultSellRetriveBody['PNR_Reply']['pnrHeader']['reservationInfo']['reservation']['controlNumber'])){
            $error = '';
            if(isset($resultSellRetriveBody['PNR_Reply']['generalErrorInfo']['errorWarningDescription']['freeText'])){
                $arrary = $resultSellRetriveBody['PNR_Reply']['generalErrorInfo']['errorWarningDescription']['freeText'];
                // dd($resultSellRetriveBody);
                $arrLength = count($arrary);
                for($i = 0; $i < $arrLength; $i++) {
                    $error.= $arrary[$i];
                }
            }
            return redirect()->route('error')->with('msg', 'Undefined index: controlNumber '. $error);
        }
        // end uddeshya code 
        $controlNumber = $resultSellRetriveBody['PNR_Reply']['pnrHeader']['reservationInfo']['reservation']['controlNumber'];
        $headerSell3 = json_encode($resultSellRetrive['header']['awsseSession'], true);
        $headerSell3 = json_decode($headerSell3);
        // dd($headerSell3);
        $actionRetriveRepeat = "PNRRET_17_1_1A";
        $xmlsellRetriveRepeat = '';
        $xmlsellRetriveRepeat .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sec="http://xml.amadeus.com/2010/06/Security_v1" xmlns:typ="http://xml.amadeus.com/2010/06/Types_v1" xmlns:iat="http://www.iata.org/IATA/2007/00/IATA2010.1" xmlns:app="http://xml.amadeus.com/2010/06/AppMdw_CommonTypes_v3" xmlns:link="http://wsdl.amadeus.com/2010/06/ws/Link_v1" xmlns:ses="http://xml.amadeus.com/2010/06/Session_v3" xmlns:pnr="http://xml.amade us.com/PNRADD_17_1_1A">';
        $xmlsellRetriveRepeat .= HeaderController::headerInSeries($actionRetriveRepeat, $headerSell3);
        $xmlsellRetriveRepeat .= '<soapenv:Body>';
        $xmlsellRetriveRepeat .= '<PNR_Retrieve xmlns="http://xml.amadeus.com/PNRRET_17_1_1A">';
        $xmlsellRetriveRepeat .= '<retrievalFacts>';
        $xmlsellRetriveRepeat .= '<retrieve>';
        $xmlsellRetriveRepeat .= '<type>2</type>';
        $xmlsellRetriveRepeat .= '</retrieve>';
        $xmlsellRetriveRepeat .= '<reservationOrProfileIdentifier>';
        $xmlsellRetriveRepeat .= '<reservation>';
        $xmlsellRetriveRepeat .= '<controlNumber>'.$controlNumber.'</controlNumber>';
        $xmlsellRetriveRepeat .= '</reservation>';
        $xmlsellRetriveRepeat .= '</reservationOrProfileIdentifier>';
        $xmlsellRetriveRepeat .= '</retrievalFacts>';
        $xmlsellRetriveRepeat .= '</PNR_Retrieve>';
        $xmlsellRetriveRepeat .= '</soapenv:Body>';
        $xmlsellRetriveRepeat .= '</soapenv:Envelope>';
        $resultsellRetriveRepeat = HeaderController::xmlCallWithBodyAndHeader2($xmlsellRetriveRepeat, $actionRetriveRepeat);
        // dd($resultsellRetriveRepeat['body']['soapFault']);
        // dd($resultsellRetriveRepeat['body'] ,$resultsellRetriveRepeat['body']['soapFault']);
        // dd($resultsellRetriveRepeat);
        if (isset($resultsellRetriveRepeat['body'])) {
            isset($resultsellRetriveRepeat['body']['PNR_Reply'])?
            $ticketData =  $resultsellRetriveRepeat['body']['PNR_Reply']: $ticktData = $resultsellRetriveRepeat['body']['PNR_Reply'];
        }else {
            return redirect()->route('error')->with('msg', 'Control number error');
        }

        if(isset($ticketData['originDestinationDetails']['itineraryInfo'][0]['hotelReservationInfo']['hotelPropertyInfo']['hotelName'])){
            $ticketDataVal = $ticketData['originDestinationDetails']['itineraryInfo'][0]['hotelReservationInfo']['hotelPropertyInfo']['hotelName'];
        }else{
            $ticketDataVal = $ticketData['originDestinationDetails']['itineraryInfo']['hotelReservationInfo']['hotelPropertyInfo']['hotelName'];
        } 

        if(!isset($ticketData['originDestinationDetails']['itineraryInfo'][0]['hotelReservationInfo']['requestedDates'])){
            $dates = $ticketData['originDestinationDetails']['itineraryInfo']['hotelReservationInfo']['requestedDates'];
        }else{
            $dates = $ticketData['originDestinationDetails']['itineraryInfo'][0]['hotelReservationInfo']['requestedDates'];
        }
        $dateStart = date_create($dates['beginDateTime']['year'] . '-' . $dates['beginDateTime']['month'] . '-' . $dates['beginDateTime']['day']);
        $dateEnd = date_create($dates['endDateTime']['year'] . '-' . $dates['endDateTime']['month'] . '-' . $dates['endDateTime']['day']);
        $diff = $dateEnd->diff($dateStart);
        $dayCount = $diff->format('%a');
        if(isset($ticketData['originDestinationDetails']['itineraryInfo'][0]['rateInformations']['ratePrice']['rateAmount'])){
            $amountFare = $ticketData['originDestinationDetails']['itineraryInfo'][0]['rateInformations']['ratePrice']['rateAmount'] * $dayCount;
        }else{
            $amountFare = $ticketData['originDestinationDetails']['itineraryInfo']['rateInformations']['ratePrice']['rateAmount'] * $dayCount;
        }

        $refno = $ticketData['pnrHeader']['reservationInfo']['reservation']['controlNumber'];
        $mailSend = MailSenders::where('refno', '=', $refno)->first();
        if (!$mailSend) {
            $mailSend = $order = new MailSenders;
            $order->email=$data->email;
            $order->amount=$request->orderAmount;
            $order->phone=$data->phoneNumber;
            $order->refno=$refno;
            $order->ismail='1';
            $order->save();

            // dd($postvalue);

            $ticketData = new TicketData;

            $ticketData->BookRef = $refno;
            $ticketData->BookID = $MttID;
            $ticketData->TicVal = $ticketDataVal;
            
            $ticketData->adultTitle = $data->adultFirstName;
            $ticketData->adultFirstName = $data->adultLastName;
            $ticketData->adultLastName = $data->adultLastName;

            $ticketData->phoneNumber = $data->phoneNumber;
            $ticketData->email = $data->email;

            $ticketData->checkin = $data->checkin;
            $ticketData->checkout = $data->checkout;
            $ticketData->night = $dayCount;

            $ticketData->HotelName = $data->HotelName;
            $ticketData->address = $data->address;

            $ticketData->Price = number_format(round($amountFare));
            $ticketData->Taxes = number_format(round($postvalue->amount - $amountFare));
            $ticketData->Total = number_format(round($postvalue->amount));
            $ticketData->PayDet =  $request['orderId'];

            $ticketData->Adults = $postvalue->adult;
            if(isset($postvalue->child)){
                $ticketData->Childs = $postvalue->child;
            }
            if(isset($postvalue->room)){
                $ticketData->Rooms = $postvalue->room;
            }else{
                $ticketData->Rooms = '1';
            }

            $ticketData->save();
            $id = TicketData::orderBy('created_at', 'desc')->first();
            $id = $id['id'];

            $maildata = [
                'resultsellRetriveRepeat'=> $resultsellRetriveRepeat,
                'postvalue'=>$postvalue ,
                'data'=> $data,
                'email'=> $data->email,
                'id' => $id
            ];
            // MailController::bassendToCus($maildata);

            // MailController::bassendToCus($maildata);
        }
        
        // dd($resultsellRetriveRepeat , $postvalue , $data);
        
        return view('hotel-pages.ticket', compact('resultsellRetriveRepeat','postvalue' , 'data', 'MttID'));
    }
    public function ticket(Request $request){
        dd($request->all());
    }
}
