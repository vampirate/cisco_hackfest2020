<!DOCTYPE html>
<html>
<head>
    <title>Your Prognosis</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/png" href="images/UN_Badge.png"/>
    <script src="self_service.js"></script>
    <script>
        window.addEventListener("beforeunload", function () {
        document.body.classList.add("animate-out");
        });
    </script>
</head>
<body class="animate-in">
    <header>
        <h1>Your Prognosis</h1>
    </header>

    <?php
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $pregnancy_duration = $_POST['pregnancy_duration'];
    $miscarriage = $_POST['miscarriage'];
    $tobacco_use = $_POST['tobacco_use'];
    $alcohol_use = $_POST['alcohol_use'];
    $height = $_POST['height']/100;
    $prepregnancy_weight = $_POST['prepregnancy_weight'];
    $current_weight = $_POST['current_weight'];
    $blood_pressure = explode("/", $_POST['blood_pressure']);
    $blood_sugar = $_POST['blood_sugar'];
    $fasting = $_POST['fasting'];
    $haemoglobin_level = $_POST['haemoglobin_level'];

    $risk = 0;
    if ($age >= 35) {
        $risk += 1;
        $age_risk = true;
    } else {
        $age_risk = false;
    }
    
    if ($miscarriage == "Yes") {
        $miscarriage_risk = true;
        if ($_POST['miscarriage_no'] == 1) {
            $risk += 1;
        } elseif ($_POST['miscarriage_no'] < 3 ) {
            $risk += 2;
        } else {
            $risk += 3;
        }
    } else {
        $miscarriage_risk = false;
    }

    if ($tobacco_use == "Yes") {
        $risk += 1;
        $tobacco_risk = true;
    } else {
        $tobacco_risk = false;
    }

    if ($alcohol_use == "Yes") {
        $risk += 2;
        $alcohol_risk = true;
    } else {
        $alcohol_risk = false;
    }


    // IMPORTANT: only calculating weight gain risk for mums in normal BMI range at the moment
    //https://www.health.qld.gov.au/news-events/news/how-much-weight-should-i-gain-while-pregnant-
    $prepregnancy_bmi = $prepregnancy_weight/($height * $height);
    $weight_diff = $current_weight - $prepregnancy_weight;
    if ($prepregnancy_bmi >= 18.5 and $prepregnancy_bmi < 24.9){    //normal BMI range
        if ($pregnancy_duration <= 13) {        // during 1st trimester
            if ($weight_diff > 2.0) {
                $risk += 1;
                $weight_risk = true;
                $weight_risk_detail = "over";
            } else {
                $weight_risk = false;
            }
        } else {        // after 1st trimester, normal weight gain is 0.2-0.5kg per week
            //https://www.healthyfamiliesbc.ca/home/articles/weight-gain-during-pregnancy-trimester
            $duration_after_first_trimester = $pregnancy_duration-13;
            $assumed_weight_after_first_trimester = $prepregnancy_weight+2;
            $assumed_weight_gain_after_first_trimester = $current_weight-$assumed_weight_after_first_trimester;
            $weight_gain_per_week = $assumed_weight_gain_after_first_trimester/$duration_after_first_trimester;
            if ($weight_gain_per_week > 0.5) {
                $risk += 1;
                $weight_risk = true;
                $weight_risk_detail = "over";
            } elseif ($weight_gain_per_week < 0.2) {
                $risk += 1;
                $weight_risk = true;
                $weight_risk_detail = "under";
            } else {
                $weight_risk = false;
            }
        }
    }

    $systolic_pressure = $blood_pressure[0];
    $diastolic_pressure = $blood_pressure[1];
    //Source: https://www.health.gov.au/resources/pregnancy-care-guidelines/part-d-clinical-assessments/blood-pressure
    if ($systolic_pressure >= 140 and $diastolic_pressure >= 90) {
        $risk += 2;
        $bp_risk = true;
    } else {
        $bp_risk = false;
    }

    //Source: https://www.health.gov.au/resourzces/pregnancy-care-guidelines/part-f-routine-maternal-health-tests/anaemia
    if ($pregnancy_duration <= 20) {
        if ($haemoglobin_level < 110) {
            $risk += 1;
            $hb_risk = true;
        } else {
            $hb_risk = false;
        }
    } else {
        if ($haemoglobin_level < 105) {
            $risk += 1;
            $hb_risk = true;
        } else {
            $hb_risk = false;
        }
    }


    //https://www.pregnancybirthbaby.org.au/diabetes-during-pregnancy
    if ($fasting == "Yes") {
        if ($blood_sugar > 5.5){
            $risk += 1;
            $bs_risk = true;
        } else {
            $bs_risk = false;
        }   
    } else {
        if ($blood_sugar > 7.0){
            $risk += 1;
            $bs_risk = true;
        } else {
            $bs_risk = false;
        }
    }

    if ($risk <= 1) {
        $risk_profile = "LOW";
    } elseif ($risk > 1 and $risk < 5){
        $risk_profile = "MODERATE";
    } else {
        $risk_profile = "HIGH";
    }
    ?>

    <?php echo "<h2>Thanks " . $first_name . " " . $last_name ." for using the Self Service page</h2>"?>

    <?php echo "<h3>Your pregnancy's current risk profile is </h3>"; ?>
    <?php echo "<div class=\"risk_report\">$risk_profile</h4>"; ?>

    <?php

        if ($risk>1) {
            echo "<br><h3>This is because of your:</h3>";
            if ($age_risk) {
                echo "<li class=\"risk_reason\">Age group</li>";
            }
            if ($miscarriage_risk) {
                echo "<li class=\"risk_reason\">Past experience in miscarriage(s)</li>";
            }
            if ($tobacco_risk and $alcohol_risk) {
                echo "<li class=\"risk_reason\">Tobacco (smoking) and alcohol use during pregnancy</li>";
            } elseif ($alcohol_risk) {
                echo "<li class=\"risk_reason\">Alcohol use during pregnancy</li>";
            } elseif ($tobacco_risk) {
                echo "<li class=\"risk_reason\">Tobacco (smoking) use during pregnancy</li>";
            }
            if ($weight_risk) {
                if ($weight_risk_detail == "over") {
                    echo "<li class=\"risk_reason\">Current weight is above target weight.</li>";
                } else {
                    echo "<li class=\"risk_reason\">Current weight is below target weight.</li>";
                }
            }
            if ($bp_risk) {
                echo "<li class=\"risk_reason\">Your blood pressure</li>";
            }
            if ($hb_risk) {
                echo "<li class=\"risk_reason\">Your haemoglobin level (how much blood you are carrying)</li>";
            }
            if ($bs_risk) {
                echo "<li class=\"risk_reason\">Your blood sugar level</li>";
            }
        }  
    ?>
    
    <br>
    <h3>If you have any queries or concerns, please seek advice of a qualified healthcare professional.</h3>

    <div class="content_selections">
        <div class="containers">
            <a href="index.html">
                <img src="images/House_1.svg"  alt="Back Icon" width="100", height="100">
                <p>Home</p>
            </a>
        </div>

        <div class="containers">
            <a href="consultation.html">
                <img src="images/Headset.svg"  alt="Home Icon" width="100", height="100">
                <p>Consultation</p>
            </a>
        </div>
    </div>

</body>
</html>