<?php

namespace App\Http\Controllers\Airline;

use App\Http\Controllers\Controller;


class AirlineHelperController extends Controller
{

    public static function getAmadeusBagg($FeesGrpCoverageInfoGrp, $baggRef)
    {
     (is_array($FeesGrpCoverageInfoGrp->serviceCoverageInfoGrp) == true) ? $onewaysServiceFeesCoverageInfoGrp = $FeesGrpCoverageInfoGrp->serviceCoverageInfoGrp : $onewaysServiceFeesCoverageInfoGrp = [$FeesGrpCoverageInfoGrp->serviceCoverageInfoGrp];
      foreach ($onewaysServiceFeesCoverageInfoGrp as $serviceCoverage){
          if ($baggRef == $serviceCoverage->itemNumberInfo->itemNumber->number){
                 (is_array($FeesGrpCoverageInfoGrp->freeBagAllowanceGrp) == true) ? $onewaysServiceBagAllowanceGrp = $FeesGrpCoverageInfoGrp->freeBagAllowanceGrp : $onewaysServiceBagAllowanceGrp = [$FeesGrpCoverageInfoGrp->freeBagAllowanceGrp];
              foreach ($onewaysServiceBagAllowanceGrp as $freeBagAllowance){
                  if ($serviceCoverage->serviceCovInfoGrp->refInfo->referencingDetail->refNumber == $freeBagAllowance->itemNumberInfo->itemNumberDetails->number){
                       ($freeBagAllowance->freeBagAllownceInfo->baggageDetails->quantityCode == 'N') ? $data =  $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance . 'PC baggage' : $data = $freeBagAllowance->freeBagAllownceInfo->baggageDetails->freeAllowance .'KG baggage';
                  }
              }
          }
       }

       return $data;
    }

}