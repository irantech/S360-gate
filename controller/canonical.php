<?php

class canonical extends clientAuth
{
    public function get() {
        if ($url = $this->checkRedirectExistence()) {
            return $url;
        }

        if (GDS_SWITCH === 'detailTour') {
            /** @var mainTour $slug_controller */
            $tout_controller = $this->getController('mainTour');
            $tout_controller->setTourData(TOUR_ID_SAME);


            /** @var tourSlugController $slug_controller */
            $slug_controller = $this->getController('tourSlugController');
            if(CLIENT_ID =='298' || CLIENT_ID =='325'){
                return $slug_controller->redirectToSlug(false);
            }
            return $slug_controller->redirectToSlug(false, true);
        } elseif (GDS_SWITCH === 'resultExternalHotel') {
            /** @var hotelSlugController $slug_controller */
            $slug_controller = $this->getController('hotelSlugController');
            $url = $slug_controller->getUrl();
            if ($url = $this->checkRedirectExistence($url)) {
                return $url;
            }
            return $this->defaultUrl();
        }elseif (GDS_SWITCH === 'buses') {

            /** @var hotelSlugController $slug_controller */
            $slug_controller = $this->getController('busSlugController');
            $url = $slug_controller->getUrl();

            if ($url = $this->checkRedirectExistence($url)) {
                return $url;
            }

            return $this->defaultUrl();
        } elseif (GDS_SWITCH === 'mag') {
            if(!empty($_GET['page'])) {
                return ROOT_ADDRESS . "/mag" ;
            }
            return $this->defaultUrl();
        } else {
            return $this->defaultUrl();
        }
    }

    public function checkRedirectExistence($currentUrl = null) {
        /** @var redirect $slug_controller */
        $slug_controller = $this->getController('redirect');

        return $slug_controller->checkDataUrl($currentUrl)['url_new'];
    }

    public function defaultUrl() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
}