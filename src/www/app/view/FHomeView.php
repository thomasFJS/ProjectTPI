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
class FHomeView{
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
        foreach($itineraries as $itinerary){
            $result .= <<<EX
            <div class="col-md-6 col-lg-4 mb-5">
            <div class="portfolio-item mx-auto card" data-toggle="modal" data-target="#portfolioModal`{$itinerary->Id}`">
                <img class="img-fluid card-img-top" src="assets/img/portfolio/cabin.png" alt="Log Cabin"/>
                <div class="card-body">                       
                    <h5 class="card-title">`{$itinerary->Title}`</h5>
                    <p class="card-text">`{$itinerary->Description}`</p>
                    <a href="#" class="btn btn-primary">More infos</a>
                </div>
            </div>
            </div>
            EX;
        }
    }
}

?>