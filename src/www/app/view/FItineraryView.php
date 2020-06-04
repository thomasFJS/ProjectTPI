<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FHomeView.
*     Brief               :  home view.
*     Date                :  02.06.2020.
*/

/**
 * Represents home page view.
 */
class FItineraryView{
    /**
     * @brief Class constructor
     */
    function __construct(){}
    /**
     * @brief Display all itineraries
     * 
     * @param array $itineraries all itineraries to display
     * 
     * @return string code html to display 
     */
    public static function DisplayItineraries(array $itineraries) : string{
        $result = '';
        for($i = 0;$i<count($itineraries);$i++){
            $result .= <<<EX
            <div class="col-md-6 col-lg-4 mb-5">
            <div class="portfolio-item mx-auto card" data-toggle="modal" data-target="#portfolioModal{$itineraries[$i]->Id}">
                <div id="map{$itineraries[$i]->Id}" class="card-img-top" style="width: 100%; height: 200px;"></div>
                <div class="card-body">                       
                    <h5 class="card-title">{$itineraries[$i]->Title}</h5>
                    <p class="card-text">{$itineraries[$i]->Description}</p>
                    <a href="#" id="info{$itineraries[$i]->Id}" class="btn btn-primary">More infos</a>
                </div>
            </div>
            </div>
            EX;
        }
        return $result;
    }

    public static function DisplayModalItineraries(array $itineraries) : string{
        $result = '';
        for($i = 0; $i<count($itineraries);$i++){
            $result .= <<<EX
            <div class="portfolio-modal modal fade" id="portfolioModal{$itineraries[$i]->Id}" tabindex="-1" role="dialog" aria-labelledby="#portfolioModal{$itineraries[$i]->Id}Label" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    <div class="modal-body text-center">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <!-- Portfolio Modal - Title-->
                                    <h2 class="portfolio-modal-title text-secondary mb-0">{$itineraries[$i]->Title}</h2>
                                    <!-- Icon Divider-->
                                    <div class="divider-custom">
                                        <div class="divider-custom-line"></div>
                                        <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                        <div class="divider-custom-line"></div>
                                    </div>
                                    <!-- Portfolio Modal - Itinerary--><div id="mapModal{$itineraries[$i]->Id}" class="img-fluid rounderd mb-5" style="width: 100%; height: 530px;"></div>                                   
                                    <!-- Portfolio Modal - Text-->
                                    <p class="mb-5">{$itineraries[$i]->Description}</p>
                                    <button class="btn btn-primary" href="#" data-dismiss="modal"><i class="fas fa-times fa-fw"></i>Close Window</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            EX;
        }

        return $result;
    }

}

?>