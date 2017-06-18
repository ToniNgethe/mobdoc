<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Search extends CI_Controller {

    function check_session() {
        if ($this->session->userdata('user_sess')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function session_id() {
        if ($this->check_session()) {
            $session_data = $this->session->userdata('user_sess');
            $userId = $session_data['userId'];
        } else {
            $userId = 0;
        }

        return $userId;
    }

    public function index() {

        $searchKey = $this->input->post('zipcode');

        $search_result = $this->searchmod->search_specialist($searchKey, $this->session_id());

        $map_results = $search_result;

        $card_output_map_two = "";
        $card_output_map_one = '<script>
            function initMap() {
                var map = new google.maps.Map(document.getElementById("mapersLocation"), {
                    zoom: 12,
                    center: {
                        lat: -1.164744,
                        lng: 37.0493746
                    }
                });
                var geocoder = new google.maps.Geocoder();

                geocodeAddress(geocoder, map);

            }
            function geocodeAddress(geocoder, resultsMap) {
            
';
        foreach ($map_results as $map_row):
            $card_output_map = '
                var contentString'. $map_row->userId . ' = '."'".'<a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' . $map_row->displayName . '</a>'."'".';

        
                var infowindow' . $map_row->userId . ' = new google.maps.InfoWindow({
                    content: contentString' . $map_row->userId . '
                });

                var address' . $map_row->userId . ' = "' . $map_row->zipcode . '";
                geocoder.geocode({
                    "address": address' . $map_row->userId . '
                }, function (results, status) {
                    if (status === "OK") {
                        resultsMap.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: resultsMap,
                            position: results[0].geometry.location,
                            title:"' . $map_row->displayName . '" 
                        });
                        
                        marker.addListener("click", function() {
                            infowindow' . $map_row->userId . '.open(map, marker);
                        });
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }
                });';
            $card_output_map_two = $card_output_map_two . '' . $card_output_map;
        endforeach;

        $card_output_map_three = '
            }

        </script>        
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqpWC20QTDao8n5EeYKSLbLXgrC6HqwIk&callback=initMap">
        </script>';


        echo $card_output_map_one . '' . $card_output_map_two . '' . $card_output_map_three;



        $card_output = '';

        if (count($search_result) > 0) {
            foreach ($search_result as $res):
                $displayName = $res->displayName;
                $facilityId = $res->facilityId;
                $docLocation = $res->zipcode;
                $docPhone = $res->myphone;
                $specialtyId = $res->specialtyId;
                $specialistId = $res->userId;
                $specialtyPhoto = $res->myavi;



                //check consultation fee
                $con_fee = $this->crudmod->read_records('billing', array('specialistId' => $specialistId));
                if (count($con_fee) > 0) {
                    foreach ($con_fee as $con_fee_row) {
                        $consultation_fee = "Ksh. " . number_format($con_fee_row->billAmount);
                        if ($con_fee_row->payLater == TRUE) {
                            $payment = "You can pay upon visiting";
                        } else {
                            $payment = "You must pay before visiting";
                        }
                    }
                } else {
                    $consultation_fee = "Not Charged";
                    $payment = null;
                }

                //Get specialty
                $docSpecialty = $this->crudmod->get_record('specialty', 'specialtyId', $specialtyId);


                //Get facility
                if ($facilityId == 0) {
                    $facilityClass = "hidden";
                } else {
                    $facilityClass = NULL;
                }
                $docFacility = $this->crudmod->get_record('facilities', 'facilityId', $facilityId);


                $card_output = '<div class="service-card card emergency-room regular">
                                <a href="' . base_url("provider/$specialistId") . '" title="' . $displayName . '" class="service-line-icon has-image emergency-room" style="background-image: url(.//avatars/' . $specialtyPhoto . ');"></a>

                                <div class="details">

                                    
                                    <strong class="service-line-label">' . $docSpecialty['sName'] . '</strong>
                                    <h4>
                                        <a title="' . $displayName . '" href="' . base_url("provider/$specialistId") . '">' . $displayName . '</a>
                                    </h4>

                                    <ul class="metadata">
                                        <li class="location">
                                            ' . $docLocation . '
                                            <span class="bullet-divider">•</span>
                                             KE
                                        </li>

                                        <li class="facility ' . $facilityClass . '">
                                            <a href="">' . $docFacility['facilityName'] . '</a>
                                        </li>
                                        <li class="phone">(254) ' . $docPhone . '</li>
                                    </ul>
                                    <!-- end .metadata -->
                                </div>
                                <!-- end .details -->


                                <div class="time-picker-container">
                                    <div class="time-picker-times">
                                        <div class="time-picker">
                                            <div class="day">Today</div>

                                            <ul class="available-times">
                                            ';

                //Get timeslots
                $date_today = date("m/d/Y");
                $timeslots = $this->crudmod->get_timeslot('timeslot', 'specialistId', $specialistId, 'timeslotId', 'timeslotDate', $date_today);

                if (count($timeslots) > 0) {
                    $time_output = '';
                    foreach ($timeslots as $timeslots_row):
                        $timeslotId = $timeslots_row->timeslotId;
                        $timeslotTime = $timeslots_row->timeslotTime;
                        $time_out = '<li class="available-time">
                                                    <a class="button secondary" href="' . base_url("startsignin?startTime=$timeslotId&professionalId=$specialistId") . '">' . $timeslotTime . '</a>
                                                </li>';
                        $time_output = $time_output . '' . $time_out;
                    endforeach;
                }else {
                    $time_output = 'No times available.';
                }


                $card_output_two = '</ul>
                                            <!-- end .available-times -->

                                        </div>
                                        <!-- end .time-picker -->

                                        <div class="consultation-fee">
                                            <label>Consultation FEE</label>                                            
                                            <a class="more-fee">' . $consultation_fee . '</a>
                                                <p>' . $payment . '</p>
                                        </div>

                                        <a href="' . base_url("provider/$specialistId") . '" class="more-times">View full schedule</a>

                                    </div>
                                </div>

                            </div>';
                echo $card_output . '' . $time_output . '' . $card_output_two;
            endforeach;
        } else {
            echo '<div class="alert alert-warning" role="alert">No doctors found in your current search. Try in a different location</div>';
        }
    }

    function filter_search() {
        $zipcode = $this->input->post('zipcode');
        $specialty = $this->input->post('specialty');

        $search_result = $this->searchmod->search_filter($zipcode, $specialty, $this->session_id());


        $map_results = $search_result;
        $card_output_map_two = "";
        $card_output_map_one = '<script>
            function initMap() {
                var map = new google.maps.Map(document.getElementById("mapersLocation"), {
                    zoom: 12,
                    center: {
                        lat: -1.164744,
                        lng: 37.0493746
                    }
                });
                var geocoder = new google.maps.Geocoder();

                geocodeAddress(geocoder, map);

            }
            
            function geocodeAddress(geocoder, resultsMap) {
            
';
        foreach ($map_results as $map_row):
            $card_output_map = '
                var address' . $map_row->userId . ' = "' . $map_row->zipcode . '";
                geocoder.geocode({
                    "address": address' . $map_row->userId . '
                }, function (results, status) {
                    if (status === "OK") {
                        resultsMap.setCenter(results[0].geometry.location);
                        var marker' . $map_row->userId . ' = new google.maps.Marker({
                            map: resultsMap,
                            position: results[0].geometry.location
                        });
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }
                });';
            $card_output_map_two = $card_output_map_two . '' . $card_output_map;
        endforeach;

        $card_output_map_three = '
            }

        </script>        
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqpWC20QTDao8n5EeYKSLbLXgrC6HqwIk&callback=initMap">
        </script>';


        echo $card_output_map_one . '' . $card_output_map_two . '' . $card_output_map_three;

        $card_output = '';

        if (count($search_result) > 0) {
            foreach ($search_result as $res):
                $displayName = $res->displayName;
                $facilityId = $res->facilityId;
                $docLocation = $res->zipcode;
                $docPhone = $res->myphone;
                $specialtyId = $res->specialtyId;
                $specialistId = $res->userId;
                $specialtyPhoto = $res->myavi;


                //check consultation fee
                $con_fee = $this->crudmod->read_records('billing', array('specialistId' => $specialistId));
                if (count($con_fee) > 0) {
                    foreach ($con_fee as $con_fee_row) {
                        $consultation_fee = "Ksh. " . number_format($con_fee_row->billAmount);
                        if ($con_fee_row->payLater == TRUE) {
                            $payment = "You can pay upon visiting";
                        } else {
                            $payment = "You must pay before visiting";
                        }
                    }
                } else {
                    $consultation_fee = "Not Charged";
                    $payment = null;
                }

                //Get specialty
                $docSpecialty = $this->crudmod->get_record('specialty', 'specialtyId', $specialtyId);


                //Get facility
                if ($facilityId == 0) {
                    $facilityClass = "hidden";
                } else {
                    $facilityClass = NULL;
                }
                $docFacility = $this->crudmod->get_record('facilities', 'facilityId', $facilityId);


                $card_output = '<div class="service-card card emergency-room regular">
                                <a href="' . base_url("provider/$specialistId") . '" title="' . $displayName . '" class="service-line-icon has-image emergency-room" style="background-image: url(.//avatars/' . $specialtyPhoto . ');"></a>

                                <div class="details">

                                    <strong class="service-line-label">' . $docSpecialty['sName'] . '</strong>
                                    <h4>
                                        <a title="' . $displayName . '" href="' . base_url("provider/$specialistId") . '">' . $displayName . '</a>
                                    </h4>


                                        

                                    <ul class="metadata">
                                        <li class="location">
                                            ' . $docLocation . '
                                            <span class="bullet-divider">•</span>
                                             KE
                                        </li>

                                        <li class="facility ' . $facilityClass . '">
                                            <a href="">' . $docFacility['facilityName'] . '</a>
                                        </li>
                                        <li class="phone">(254) ' . $docPhone . '</li>
                                    </ul>
                                    <!-- end .metadata -->
                                </div>
                                <!-- end .details -->


                                <div class="time-picker-container">
                                    <div class="time-picker-times">
                                        <div class="time-picker">
                                            <div class="day">Today</div>

                                            <ul class="available-times">
                                            ';

                //Get timeslots
                $date_today = date("m/d/Y");
                $timeslots = $this->crudmod->get_timeslot('timeslot', 'specialistId', $specialistId, 'timeslotId', 'timeslotDate', $date_today);

                if (count($timeslots) > 0) {
                    $time_output = '';
                    foreach ($timeslots as $timeslots_row):
                        $timeslotId = $timeslots_row->timeslotId;
                        $timeslotTime = $timeslots_row->timeslotTime;
                        $time_out = '<li class="available-time">
                                                    <a class="button secondary" href="' . base_url("startsignin?startTime=$timeslotId&professionalId=$specialistId") . '">' . $timeslotTime . '</a>
                                                </li>';
                        $time_output = $time_output . '' . $time_out;
                    endforeach;
                }else {
                    $time_output = 'No times available.';
                }


                $card_output_two = '</ul>
                                            <!-- end .available-times -->

                                        </div>
                                        <!-- end .time-picker -->

                                        
                                        <div class="consultation-fee">
                                            <label>Consultation FEE</label>                                            
                                            <a class="more-fee">' . $consultation_fee . '</a>
                                                <p>' . $payment . '</p>
                                        </div>

                                        <a href="' . base_url("provider/$specialistId") . '" class="more-times">View full schedule</a>

                                    </div>
                                </div>

                            </div>';
                echo $card_output . '' . $time_output . '' . $card_output_two;
            endforeach;
        } else {
            echo '<div class="alert alert-warning" role="alert">No doctors found in your current search. Try in a different location</div>';
        }
    }

    function provider($providerId) {
        $providerDetails = $this->crudmod->get_where_one_join('user', 'userId', $providerId, 'specialist', 'userId', 'userId');
        foreach ($providerDetails as $row) {
            $displayName = $row->displayName;
            $facilityId = $row->facilityId;
            $specialtyPhoto = $row->myavi;
            $qualification = $row->qualification;
            $specialistId = $row->userId;
            $specialtyId = $row->specialtyId;
            $docLocation = $row->zipcode;
            $docPhone = $row->myphone;
            $certificationId = $row->certificationId;
        }

        //Get specialty
        $docSpecialty = $this->crudmod->get_record('specialty', 'specialtyId', $specialtyId);


        //Get facility
        if ($facilityId == 0) {
            $facilityClass = "hidden";
        } else {
            $facilityClass = NULL;
        }
        $docFacility = $this->crudmod->get_record('facilities', 'facilityId', $facilityId);

        //Certification
        $docCertification = $this->crudmod->get_record('certifications', 'certificationId', $certificationId);

        $data = array(
            'displayName' => $displayName,
            'qualification' => $qualification,
            'specialtyPhoto' => $specialtyPhoto,
            'specialistId' => $specialistId,
            'docSpecialty' => $docSpecialty,
            'docLocation' => $docLocation,
            'docPhone' => $docPhone,
            'facilityClass' => $facilityClass,
            'docFacility' => $docFacility,
            'docCertification' => $docCertification
        );


        $this->load->view('provider', $data);
    }

    function filterprovider() {
        $filterdate = $this->input->post('filterdate');
        $specialistId = $this->input->post('specialistId');


        if (date("m/d/Y", strtotime($filterdate)) <= date("m/d/Y")) {
            $filterdate = date("m/d/Y");
        } else {
            
        }



        $timeslots = $this->searchmod->search_timeslot('timeslot', 'specialistId', $specialistId, 'timeslotId', 'timeslotDate', $filterdate);

        $card_output = '
                            <div class="time-picker">
                                <ul class="available-times">
                                ';



        if (count($timeslots) > 0) {
            $time_output = '';
            foreach ($timeslots as $timeslots_row):
                $timeslotId = $timeslots_row->timeslotId;
                $timeslotTime = $timeslots_row->timeslotTime;
                $time_out = '<li class="available-time">
                                                    <a class="button secondary" href="' . base_url("startsignin?startTime=$timeslotId&professionalId=$specialistId") . '">' . $timeslotTime . '</a>
                                                </li>';
                $time_output = $time_output . '' . $time_out;
            endforeach;
        }else {
            $time_output = 'No times available.';
        }


        $card_output_two = '</ul>
                                            <!-- end .available-times -->

                                        </div>
                                        <!-- end .time-picker -->


                                      </div>
                                ';
        echo $card_output . '' . $time_output . '' . $card_output_two;
    }

}
