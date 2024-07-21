<?php
namespace App\Http\Controllers\HotelOld\Amadeus;

use App\Http\Controllers\Controller;
use App\Models\HotelLog;
use App\Models\Hotel\Hotelcode;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\VisitorGeolocation;
use Illuminate\Support\Facades\Session;

class HeaderController extends Controller
{
    public function searchCityCode(Request $request)
    {
        $search = $request['search'];

        if ($search == '') {
            $employees = Hotelcode::orderby('State', 'DESC')->select('id', 'iata', 'city', 'country')->limit(20)->get();
        //   dd($employees);
        } else {

            $employees = Hotelcode::orderby('State', 'DESC')->where('city', 'like', $search.'%')
                //  ->orWhere('State', 'like', $search .'%')
                 ->orWhere('country', 'like', $search .'%')
                //  ->orWhere('City Code', 'like', $search .'%')
                //  ->orWhere('State Code', 'like', $search .'%')
                 ->limit(20)->get();

        }
        $response = array();
        foreach ($employees as $employee) {
            $response[] = array(
                "id" => $employee['iata'],
                "text" => $employee['city'] . " ( " .$employee["iata"]  ." ) "  .$employee["country"] ,
            );
        }

        echo json_encode($response);
        exit;
    }
    public function headerStateLess($action)
    {
        $config = Config::get('configuration.Amadeus');
        $MID = (string) Str::uuid();
        $nonce = random_bytes(8);
        date_default_timezone_set("UTC");
        $t = microtime(true);
        $micro = sprintf("%03d", ($t - floor($t)) * 1000);
        $date = new \DateTime(date('Y-m-d H:i:s.' . $micro));
        $created = $date->format("Y-m-d\TH:i:s:") . $micro . 'Z';
        $encodedNonce = base64_encode($nonce);
        $passworddigest = base64_encode(sha1($nonce . $created . sha1($config['password'], true), true));
        $xml = '';
        $xml .= '<soapenv:Header>';
        $xml .= '<add:MessageID xmlns:add="http://www.w3.org/2005/08/addressing">' . $MID . '</add:MessageID>';
        $xml .= '<add:Action xmlns:add="http://www.w3.org/2005/08/addressing">http://webservices.amadeus.com/' . $action . '</add:Action>';
        $xml .= '<add:To xmlns:add="http://www.w3.org/2005/08/addressing">' . $config['url'] . '</add:To>';
        $xml .= '<link:TransactionFlowLink xmlns:link="http://wsdl.amadeus.com/2010/06/ws/Link_v1"/>';
        $xml .= '<oas:Security xmlns:oas="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">';
        $xml .= '<oas:UsernameToken oas1:Id="UsernameToken-1" xmlns:oas1="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">';
        $xml .= '<oas:Username>' . $config['user_id'] . '</oas:Username>';
        $xml .= '<oas:Nonce EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">' . $encodedNonce . '</oas:Nonce>';
        $xml .= '<oas:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordDigest">' . $passworddigest . '</oas:Password>';
        $xml .= '<oas1:Created>' . $created . '</oas1:Created>';
        $xml .= '</oas:UsernameToken>';
        $xml .= '</oas:Security>';
        $xml .= '<AMA_SecurityHostedUser xmlns="http://xml.amadeus.com/2010/06/Security_v1">';
        $xml .= '<UserID AgentDutyCode="SU" POS_Type="1" PseudoCityCode="' . $config['office_id'] . '" RequestorType="U"/>';
        $xml .= '</AMA_SecurityHostedUser>';
        $xml .= '</soapenv:Header>';
        return $xml;
    }

    public function headerStateFull($action)
    {
        $config = Config::get('configuration.Amadeus');
        $MID = (string) Str::uuid();
        $nonce = random_bytes(8);
        date_default_timezone_set("UTC");
        $t = microtime(true);
        $micro = sprintf("%03d", ($t - floor($t)) * 1000);
        $date = new \DateTime(date('Y-m-d H:i:s.' . $micro));
        $created = $date->format("Y-m-d\TH:i:s:") . $micro . 'Z';
        $encodedNonce = base64_encode($nonce);
        $passworddigest = base64_encode(sha1($nonce . $created . sha1($config['password'], true), true));
        $xml = '';
        $xml .= '<soapenv:Header>';
        $xml .= '<add:MessageID xmlns:add="http://www.w3.org/2005/08/addressing">' . $MID . '</add:MessageID>';
        $xml .= '<add:Action xmlns:add="http://www.w3.org/2005/08/addressing">http://webservices.amadeus.com/' . $action . '</add:Action>';
        $xml .= '<add:To xmlns:add="http://www.w3.org/2005/08/addressing">' . $config['url'] . '</add:To>';
        $xml .= '<link:TransactionFlowLink xmlns:link="http://wsdl.amadeus.com/2010/06/ws/Link_v1"/>';
        $xml .= '<oas:Security xmlns:oas="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">';
        $xml .= '<oas:UsernameToken oas1:Id="UsernameToken-1" xmlns:oas1="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">';
        $xml .= '<oas:Username>' . $config['user_id'] . '</oas:Username>';
        $xml .= '<oas:Nonce EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">' . $encodedNonce . '</oas:Nonce>';
        $xml .= '<oas:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordDigest">' . $passworddigest . '</oas:Password>';
        $xml .= '<oas1:Created>' . $created . '</oas1:Created>';
        $xml .= '</oas:UsernameToken>';
        $xml .= '</oas:Security>';
        $xml .= '<AMA_SecurityHostedUser xmlns="http://xml.amadeus.com/2010/06/Security_v1">';
        $xml .= '<UserID AgentDutyCode="SU" POS_Type="1" PseudoCityCode="' . $config['office_id'] . '" RequestorType="U"/>';
        $xml .= '</AMA_SecurityHostedUser>';
        $xml .= '<awsse:Session TransactionStatusCode="Start" xmlns:awsse="http://xml.amadeus.com/2010/06/Session_v3"/>';
        $xml .= '</soapenv:Header>';
        return $xml;
    }

    public static function headerInSeries($a, $header)
    {
        $MID = (string) Str::uuid();

        $xml = '';
        $xml .= ' <soapenv:Header xmlns:add="http://www.w3.org/2005/08/addressing">';
        $xml .= ' <add:MessageID>' . $MID . '</add:MessageID>';
        $xml .= ' <add:Action>http://webservices.amadeus.com/' . $a . '</add:Action>';
        $xml .= ' <add:To>https://nodeD1.production.webservices.amadeus.com/1ASIWMAKFTT</add:To>';
        $xml .= ' <awsse:Session TransactionStatusCode="InSeries" xmlns:awsse="http://xml.amadeus.com/2010/06/Session_v3">';
        $xml .= ' <awsse:SessionId>' . $header->awsseSessionId . '</awsse:SessionId>';
        $xml .= ' <awsse:SequenceNumber>' . array_sum([$header->awsseSequenceNumber, 1]) . '</awsse:SequenceNumber>';
        $xml .= ' <awsse:SecurityToken>' . $header->awsseSecurityToken . '</awsse:SecurityToken>';
        $xml .= ' </awsse:Session>';
        $xml .= ' </soapenv:Header>';

        return $xml;
    }

    public function xmlCallWithHeader($xml, $action)
    {
        $config = Config::get('configuration.Amadeus');
        $data = Http::withHeaders([
            "Content-Type" => "application/xml",
            "SoapAction" => $config['action'] . $action,
        ])->send("POST", $config['url'], [
            "body" => $xml,
        ])->body();

        $data = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $data);
        $x = new \SimpleXMLElement($data);
        $header = $x->xpath('//soapHeader')[0];
        $body = $x->xpath('//soapBody')[0];

        $bodyData = json_decode(json_encode((array) $body, true), true);
        return $bodyData;
    }

    public static function xmlCallWithBodyAndHeader($xml, $action)
    {
        $config = Config::get('configuration.Amadeus');

        $data = Http::withHeaders([
            "Content-Type" => "application/xml",
            "SoapAction" => $config['action'] . $action,
        ])->send("POST", $config['url'], [
            "body" => $xml,
        ])->body();
        $dataSave = "<request>".$xml."<request/><response>".$data."<response/>";
        $data = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $data);
        $x = new \SimpleXMLElement($data);
        $header = $x->xpath('//soapHeader')[0];
        $body = $x->xpath('//soapBody')[0];
        $headerData = json_decode(json_encode((array) $header, true), true);
        $headerDataSessionId = $headerData['awsseSession']['awsseSessionId'];

        if ($action == "Hotel_MultiAvailability_10.0") {
            $flightLogs = new HotelLog;
            $flightLogs->session_id = $headerDataSessionId;
            $flightLogs->authenticate = $header;
            $flightLogs->single_availability = $dataSave;
            $flightLogs->save();
        }elseif($action == "Hotel_EnhancedPricing_2.0") {
            $flightLogs = HotelLog::where('session_id', '=', $headerDataSessionId)->first();
            $flightLogs->enhanced_pricing = $dataSave;
            $flightLogs->save();
        }
        $bodyData = json_decode(json_encode((array) $body, true), true);
        $headerData = json_decode(json_encode((array) $header, true), true);
        return ["body" => $bodyData, "header" => $headerData];
    }

    public static function xmlCallWithBodyAndHeader2($xml, $action)
    {
        $actionCh = "";
        if ($action == "PNRADD_17_1_1A_0") {
            $actionCh = "PNRADD_17_1_1A_0";
            $action = "PNRADD_17_1_1A";
        }elseif ($action == "PNRADD_17_1_1A_10"){
            $actionCh = "PNRADD_17_1_1A_10";
            $action = "PNRADD_17_1_1A";
        }elseif($action == "Hotel_MultiAvailability_10.0"){
            $action = "Hotel_MultiAvailability_10.0";
        }
        $config = Config::get('configuration.Amadeus');
        $data = Http::withHeaders([
            "Content-Type" => "application/xml",
            "SoapAction" => $config['action'] . $action,
        ])->send("POST", $config['url'], [
            "body" => $xml,
        ])->body();

        $dataSave = "<request>".$xml."<request/><response>".$data."<response/>";

        $data = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $data);
        $x = new \SimpleXMLElement($data);

        // dd($x);
        $header = $x->xpath('//soapenvHeader')[0];
        // $header = $x->xpath('//soapHeader')[0];

        $body = $x->xpath('//soapenvBody')[0];
        // $body = $x->xpath('//soapBody')[0];

        $headerData = json_decode(json_encode((array) $header, true), true);
        $headerDataSessionId = $headerData['awsseSession']['awsseSessionId'];
        if($actionCh == "PNRADD_17_1_1A_0") {
            $action = "PNRADD_17_1_1A";
            $flightLogs = HotelLog::where('session_id', '=', $headerDataSessionId)->first();
            $flightLogs->add_multi_elements_zero = $dataSave;
            $flightLogs->save();
        }
        elseif($action == "HBKRCQ_17_1_1A") {
            $flightLogs = HotelLog::where('session_id', '=', $headerDataSessionId)->first();
            $flightLogs->hotel_sell = $dataSave;
            $flightLogs->save();
        }
        elseif($actionCh == "PNRADD_17_1_1A_10") {
            $action = "PNRADD_17_1_1A";
            $flightLogs = HotelLog::where('session_id', '=', $headerDataSessionId)->first();
            $flightLogs->add_multi_elements_ten = $dataSave;
            $flightLogs->save();
        }
        elseif($action == "PNRRET_17_1_1A") {
            $flightLogs = HotelLog::where('session_id', '=', $headerDataSessionId)->first();
            $flightLogs->retrieve = $dataSave;
            $flightLogs->save();
        }elseif($action == "Hotel_MultiAvailability_10.0"){
            $flightLogs = HotelLog::where('session_id', '=', $headerDataSessionId)->first();
            $flightLogs->multi_availability = $dataSave;
            $flightLogs->save();
        }
        $bodyData = json_decode(json_encode((array) $body, true), true);
        $headerData = json_decode(json_encode((array) $header, true), true);
        $data = ["body" => $bodyData, "header" => $headerData];
        // dd($data);
        // return $data;
        return (["body" => $bodyData, "header" => $headerData]);
    }

    public function SearchHotel(Request $request)
    {
        $adult = $request['adult'];

        $state = $request['state'];

        $departDate = $request['departDate'];
        $returnDate = $request['returnDate'];

        $child = $request['child'];

        $room = $request['room'];

        $count_A_C = $adult + $child;

        $start = date('Y-m-d', strtotime($request['departDate']));
        /////////////////////////////// uddeshya changes
        $start1 = date('Y-m-d', strtotime($request['departDate']));
        $end1 = date('Y-m-d', strtotime($request['returnDate']));
        $date1=date_create($start1);
        $date2=date_create($end1);
        /////////////////////////////// uddeshya

        $end = date('Y-m-d', strtotime($request['returnDate']));
        $query_currency = DB::table('latest_currency_exchanges')
                            ->distinct('code')
                            ->groupBy('id')
                            ->pluck('value' , 'code')
                            ->toArray();

        $currencyconversion = VisitorGeolocation::geolocationInfo();
        $action = "Hotel_MultiAvailability_10.0";
        $xml = '';
        $xml .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sec="http://xml.amadeus.com/2010/06/Security_v1" xmlns:typ="http://xml.amadeus.com/2010/06/Types_v1" xmlns:iat="http://www.iata.org/IATA/2007/00/IATA2010.1" xmlns:app="http://xml.amadeus.com/2010/06/AppMdw_CommonTypes_v3" xmlns:link="http://wsdl.amadeus.com/2010/06/ws/Link_v1" xmlns:ses="http://xml.amadeus.com/2010/06/Session_v3" xmlns:ns="http://www.opentravel.org/OTA/2003/05">';
        $xml .= $this->headerStateLess($action);
        $xml .= '<soapenv:Body>';
        $xml .= '<OTA_HotelAvailRQ xmlns="http://www.opentravel.org/OTA/2003/05" EchoToken="MultiSingle" Version="4.000" SummaryOnly="true" AvailRatesOnly="true" OnRequestInd="true" RateRangeOnly="true" ExactMatchOnly="false" SearchCacheLevel="VeryRecent" RequestedCurrency="GBP" RateDetailsInd="true">';
        $xml .= '<AvailRequestSegments>';
        $xml .= '<AvailRequestSegment InfoSource="Distribution">';
        $xml .= '<HotelSearchCriteria AvailableOnlyIndicator="true">';
        $xml .= '<Criterion ExactMatch="true">';
        $xml .= '<HotelRef HotelCityCode="' . $request['state'] . '"/>';
        $xml .= '<StayDateRange Start="' . $start . '" End="' . $end . '"/>';
        $xml .= '<RoomStayCandidates>';
        $xml .= '<RoomStayCandidate RoomID="1" Quantity="' . $room . '">';
        $xml .= '<GuestCounts>';
        $xml .= '<GuestCount AgeQualifyingCode="10" Count="' . $count_A_C . '"/>';
        $xml .= '</GuestCounts>';
        $xml .= '</RoomStayCandidate>';
        $xml .= '</RoomStayCandidates>';
        $xml .= '</Criterion>';
        $xml .= '</HotelSearchCriteria>';
        $xml .= '</AvailRequestSegment>';
        $xml .= '</AvailRequestSegments>';
        $xml .= '</OTA_HotelAvailRQ>';
        $xml .= '</soapenv:Body>';
        $xml .= '</soapenv:Envelope>';

        $hotels = $this->xmlCallWithHeader($xml, $action);
        // $symbol = !empty($currencyconversion['symbol']) ? $currencyconversion['symbol'] :'INR';
        // $cvalue = !empty($currencyconversion['value']) ? $currencyconversion['value'] :1; // conversion value
        $currency_code = !empty(Session::get('currency')) ? Session::get('currency') : 'INR';
        // dd($currencyconversion);
        if (!isset($hotels['OTA_HotelAvailRS']['HotelStays'])) {
            //////////////////////////// uddeshya  changes
            $errorMsg="";
            if(isset($hotels['OTA_HotelAvailRS']['Warnings'])){
                if(isset($hotels['OTA_HotelAvailRS']['Warnings']['Warning']['0'])){
                    $worning = $hotels['OTA_HotelAvailRS']['Warnings']['Warning']['0']['@attributes']['Status'];
                }else{
                    $worning = 'Unknown Warning';
                }
                // dd($worning);
                $errorMsg= "This is a Warning ". $worning;

            }elseif(isset($hotels['OTA_HotelAvailRS']['Errors'])){

                $ErrorCode = $hotels['OTA_HotelAvailRS']['Errors']['Error']['@attributes']['Code'];

                if($ErrorCode== '404'){
                    $errorMsg ="Invalid start Or End date.";
                }else if($ErrorCode=='450'){
                    $errorMsg ='Unable to proecss';
                }elseif($ErrorCode=='377'){
                    $errorMsg ='Invalied - max number of nights.';
                }elseif($ErrorCode =='431'){
                    $errorMsg = 'Out date past End date.';
                }elseif($ErrorCode =='145'){
                    $errorMsg = 'Duration period or dates incorrect.';
                }elseif($ErrorCode =='119'){
                    $errorMsg = 'Too many people in room/unit.';
                }elseif($ErrorCode=='424'){
                    $errorMsg ='No hotels found which match this input.';
                }else {
                    $errorMsg ='Hotels found which match this input.'.$ErrorCode;
                }

                // dd($hotels['OTA_HotelAvailRS']['Errors']);
            }

            $diff=date_diff($date1,$date2);

            if($diff->format("%R%a days") =='+0 days'){
                // $errorMsg.= $diff->format("%R%a days");
            }elseif($diff->format("%R%a days") =='+1 days'){
                // $errorMsg.= $diff->format("%R%a days");
            }else{
                // $errorMsg.= $diff->format("%R%a days");
            }
            return redirect()->route('error')->with('msg', $errorMsg);
            /////////////////////////////////

            // Commented by uddeshya
            // return redirect()->route('error')->with('msg', 'Hotels Not Found.');
        }
        // Session()->put('city', $hotels , 'value', $hotels);
        // dd($state ,$start ,$end);
        // Session()->put('value', $hotels);

        $searchSession = [
                'hotels' => $hotels,
                'start' => $start,
                'end' => $end,
                'adult' => $adult,
                'child' => $child,
                'state' => $state,
                'returnDate' => $returnDate,
                'departDate' => $departDate,
                'room' => $room,
        ];
        Session()->put('searchSession' , $searchSession);

        // return view('hotel-pages.search-hotel', compact('hotels', 'start', 'end', 'adult', 'child' , 'state' ,'returnDate' ,'departDate', 'room' , 'symbol' , 'cvalue'));
        return view('hotel-pages.search-hotel', compact('hotels', 'start', 'end', 'adult', 'child' , 'state' ,'returnDate' ,'departDate', 'room' , 'query_currency' , 'currency_code'));
    }

    public function HotelInfo($hotelCode)
    {
        $action = "OTA_HotelDescriptiveInfoRQ_07.1_1A2007A";
        $xml = '';
        $xml .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sec="http://xml.amadeus.com/2010/06/Security_v1" xmlns:typ="http://xml.amadeus.com/2010/06/Types_v1" xmlns:iat="http://www.iata.org/IATA/2007/00/IATA2010.1" xmlns:app="http://xml.amadeus.com/2010/06/AppMdw_CommonTypes_v3" xmlns:link="http://wsdl.amadeus.com/2010/06/ws/Link_v1" xmlns:ses="http://xml.amadeus.com/2010/06/Session_v3" xmlns:ns="http://www.opentravel.org/OTA/2003/05">';
        $xml .= $this->headerStateLess($action);
        $xml .= '<soapenv:Body>';
        $xml .= '<OTA_HotelDescriptiveInfoRQ xmlns="http://www.opentravel.org/OTA/2003/05" EchoToken="WithParsing" Version="6.001" PrimaryLangID="en">';
        $xml .= '<HotelDescriptiveInfos>';
        $xml .= '<HotelDescriptiveInfo HotelCode="' . $hotelCode . '">';
        $xml .= '<HotelInfo SendData="true"/>';
        $xml .= '<FacilityInfo SendGuestRooms="true" SendMeetingRooms="true" SendRestaurants="true"/>';
        $xml .= '<Policies SendPolicies="true"/>';
        $xml .= '<AreaInfo SendAttractions="true" SendRecreations="true" SendRefPoints="true"/>';
        $xml .= '<AffiliationInfo SendAwards="true" SendLoyalPrograms="true" />';
        $xml .= '<ContactInfo SendData="true"/>';
        $xml .= '<MultimediaObjects SendData="true"/>';
        $xml .= '<ContentInfos>';
        $xml .= '<ContentInfo Name="SecureMultimediaURLs"/>';
        $xml .= '</ContentInfos>';
        $xml .= '</HotelDescriptiveInfo>';
        $xml .= '</HotelDescriptiveInfos>';
        $xml .= '</OTA_HotelDescriptiveInfoRQ>';
        $xml .= '</soapenv:Body>';
        $xml .= '</soapenv:Envelope>';
        $hotels = $this->xmlCallWithHeader($xml, $action);
        return $hotels['OTA_HotelDescriptiveInfoRS']['HotelDescriptiveContents']['HotelDescriptiveContent'];
    }
    public function HotelInfoAjax(Request $request){
        if(!empty($request->hotelcode)){
        $hotelCode = $request->hotelcode;
        $action = "OTA_HotelDescriptiveInfoRQ_07.1_1A2007A";
        $xml = '';
        $xml .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sec="http://xml.amadeus.com/2010/06/Security_v1" xmlns:typ="http://xml.amadeus.com/2010/06/Types_v1" xmlns:iat="http://www.iata.org/IATA/2007/00/IATA2010.1" xmlns:app="http://xml.amadeus.com/2010/06/AppMdw_CommonTypes_v3" xmlns:link="http://wsdl.amadeus.com/2010/06/ws/Link_v1" xmlns:ses="http://xml.amadeus.com/2010/06/Session_v3" xmlns:ns="http://www.opentravel.org/OTA/2003/05">';
        $xml .= $this->headerStateLess($action);
        $xml .= '<soapenv:Body>';
        $xml .= '<OTA_HotelDescriptiveInfoRQ xmlns="http://www.opentravel.org/OTA/2003/05" EchoToken="WithParsing" Version="6.001" PrimaryLangID="en">';
        $xml .= '<HotelDescriptiveInfos>';
        $xml .= '<HotelDescriptiveInfo HotelCode="' . $hotelCode . '">';
        $xml .= '<HotelInfo SendData="true"/>';
        $xml .= '<FacilityInfo SendGuestRooms="true" SendMeetingRooms="true" SendRestaurants="true"/>';
        $xml .= '<Policies SendPolicies="true"/>';
        $xml .= '<AreaInfo SendAttractions="true" SendRecreations="true" SendRefPoints="true"/>';
        $xml .= '<AffiliationInfo SendAwards="true" SendLoyalPrograms="true" />';
        $xml .= '<ContactInfo SendData="true"/>';
        $xml .= '<MultimediaObjects SendData="true"/>';
        $xml .= '<ContentInfos>';
        $xml .= '<ContentInfo Name="SecureMultimediaURLs"/>';
        $xml .= '</ContentInfos>';
        $xml .= '</HotelDescriptiveInfo>';
        $xml .= '</HotelDescriptiveInfos>';
        $xml .= '</OTA_HotelDescriptiveInfoRQ>';
        $xml .= '</soapenv:Body>';
        $xml .= '</soapenv:Envelope>';
        $hotels = $this->xmlCallWithHeader($xml, $action);
        $hotelDescriptiveContent = $hotels['OTA_HotelDescriptiveInfoRS']['HotelDescriptiveContents']['HotelDescriptiveContent'];
            $hotelDescriptionsImageRoutes = $hotels['OTA_HotelDescriptiveInfoRS']['HotelDescriptiveContents']['HotelDescriptiveContent'];
            $hotelDescriptionsImageRoutes = !empty($hotelDescriptiveContent['HotelInfo']['Descriptions']['MultimediaDescriptions']['MultimediaDescription']) ? $hotelDescriptiveContent['HotelInfo']['Descriptions']['MultimediaDescriptions']['MultimediaDescription'] : [];
            if(!empty($hotelDescriptionsImageRoutes)){
            $hotelDescriptionsImageRoutess = array_column($hotelDescriptionsImageRoutes, 'ImageItems');
            }
            else{
            $hotelDescriptionsImageRoutess = [];
            }
            $hotelImagesRow = [];
            if (!empty($hotelDescriptionsImageRoutess)) {
                foreach ($hotelDescriptionsImageRoutess as $hotelDescriptionsRow) {
                    isset($hotelDescriptionsRow['ImageItem'][0]) ? $hotelDescriptionsRowImageItem = $hotelDescriptionsRow['ImageItem'] : $hotelDescriptionsRowImageItem = [$hotelDescriptionsRow['ImageItem']];
                    foreach ($hotelDescriptionsRowImageItem as $HotelImageArrays) {
                        if (isset($HotelImageArrays['Description'])) {
                            //dd($HotelImageArrays);
                            isset($HotelImageArrays['Description']['@attributes']['Caption'])?
                            $HotelImageArraysDescription = $HotelImageArrays['Description']['@attributes']['Caption'] : $HotelImageArraysDescription = $HotelImageArrays['Description'];

                            if(!is_array($HotelImageArraysDescription)){
                                if (strpos($HotelImageArraysDescription, 'Exterior') !== false) {
                                    array_push($hotelImagesRow, $HotelImageArrays['ImageFormat']);
                                    break;
                                } else {
                                    array_push($hotelImagesRow, $HotelImageArrays['ImageFormat']);
                                    break;
                                }
                            }
                        } else {
                            array_push($hotelImagesRow, $HotelImageArrays['ImageFormat']);
                            break;
                        }
                    }
            }
            }else{
                $hotelImagesRow[] = [
                    ["URL" => asset('assets/images/hotel/h3.jpg')],
                ];
            }
            if(isset($hotelImagesRow[0][0]['URL'])){
                $IMGurl =$hotelImagesRow[0][0]['URL'];
            }else{
                $IMGurl = '';
            }
            return response()->json(['url' => $IMGurl]);
        }
    }
    // code by uddeshya
    public function errors(Request $request){
        $ErrorCode = $request['code'];
        $ErrorType = $request['type'];

        $errorMsg = '';
        if($ErrorCode== '23'){
            $errorMsg ="Passenger typr not supported.";
        }else if($ErrorCode=='450'){
            $errorMsg ='Unable to proecss';
        }
        $errorMsg =$errorMsg;

        return redirect()->route('error')->with('msg', $errorMsg);

    }
    // code end  by uddeshya

    public function HotelDetails(Request $request) {
       $requestdata = $request->all();

       $searchSession = Session('searchSession');








        // dd($requestdata ,$searchSession);
        $action = "Hotel_MultiAvailability_10.0";
        $adult = $searchSession['adult'];
        $child = $searchSession['child'];
        // code by uddeshya  one line
        $state = $request['hotelcitycode'];
        $showdepartDate = $request['showdepartDate'];
        $showreturnDate = $request['showreturnDate'];

        $start = date('Y-m-d', strtotime($searchSession['start']));

        $end = date('Y-m-d', strtotime($searchSession['end']));

        $xml = '';
        $xml .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sec="http://xml.amadeus.com/2010/06/Security_v1" xmlns:typ="http://xml.amadeus.com/2010/06/Types_v1" xmlns:iat="http://www.iata.org/IATA/2007/00/IATA2010.1" xmlns:app="http://xml.amadeus.com/2010/06/AppMdw_CommonTypes_v3" xmlns:link="http://wsdl.amadeus.com/2010/06/ws/Link_v1" xmlns:ses="http://xml.amadeus.com/2010/06/Session_v3" xmlns:ns="http://www.opentravel.org/OTA/2003/05">';
        $xml .= $this->headerStateFull($action);
        $xml .= '<soapenv:Body>';
        $xml .= '<OTA_HotelAvailRQ xmlns="http://www.opentravel.org/OTA/2003/05" EchoToken="MultiSingle" Version="4.000" SummaryOnly="true" AvailRatesOnly="true" OnRequestInd="true" SearchCacheLevel="Live" RateRangeOnly="true" ExactMatchOnly="false" RateDetailsInd="true">';
        $xml .= '<AvailRequestSegments>';
        $xml .= '<AvailRequestSegment InfoSource="Distribution">';
        $xml .= '<HotelSearchCriteria AvailableOnlyIndicator="true">';
        $xml .= '<Criterion ExactMatch="true">';
        $xml .= '<HotelRef ChainCode="' . $request['chaincode'] . '" HotelCode="' . $request['hotelcode'] . '" HotelCityCode="' . $request['hotelcitycode'] . '"/>';
        $xml .= '<StayDateRange Start="' . $start . '" End="' . $end . '"/>';
        $xml .= '<RoomStayCandidates>';
        $xml .= '<RoomStayCandidate RoomID="1" Quantity="1">';
        $xml .= '<GuestCounts>';
        $xml .= '<GuestCount AgeQualifyingCode="10" Count="' . $adult . '"/>';
        $xml .= '</GuestCounts>';
        $xml .= '</RoomStayCandidate>';
        $xml .= '</RoomStayCandidates>';
        $xml .= '</Criterion>';
        $xml .= '</HotelSearchCriteria>';
        $xml .= '</AvailRequestSegment>';
        $xml .= '</AvailRequestSegments>';
        $xml .= '</OTA_HotelAvailRQ>';
        $xml .= '</soapenv:Body>';
        $xml .= '</soapenv:Envelope>';
        $result = $this->xmlCallWithBodyAndHeader($xml, $action);


        $detail = $result['body'];
        $header = $result['header']['awsseSession'];

        $SessionDetails = [
            'start' => $start,
            'end' => $end,
            'adult' => $adult,
            'child' => $child,
            'header' => $header,
            'state' => $state,
            'showdepartDate' => $showdepartDate,
            'showreturnDate' => $showreturnDate,
            'detail' => $detail,
        ];

        $currencyconversion = VisitorGeolocation::geolocationInfo();
        $symbol = !empty($currencyconversion['symbol']) ? $currencyconversion['symbol'] : '₹';
        $cvalue = !empty($currencyconversion['value']) ?  $currencyconversion['value'] : 1;
        $request->session()->put('SessionDetails', $SessionDetails);
        // dd($detail);
        return view('hotel-pages.details-hotel', compact('detail', 'start', 'end', 'adult', 'child', 'header' ,'state' ,'showdepartDate' , 'showreturnDate' , 'symbol' , 'cvalue'));
    }
    public function test(Request $request){
        dd($request);
    }

}
