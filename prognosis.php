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
    
    if ($miscarriage = "Yes") {
        if ($_POST['miscarriage_no'] >= 2) {
            $risk += 1;
            $miscarriage_risk = true;
        } else {
            $miscarriage_risk = false;
        }
    } else {
        $miscarriage_risk = false;
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
        $risk += 1;
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

    if ($risk > 0) {
        $risk_profile = "HIGH";
        $color = "#ef4023";
    } else {
        $risk_profile = "LOW";
        $color = "#1dbd45";
    }
    ?>

    <?php echo "<h2>Thanks " . $first_name . " " . $last_name ." for using the Self Service page</h2>"?>

    <?php echo "<h3>Your pregnancy's current risk profile is </h3>"; ?>
    <?php echo "<div class=\"risk_report\" style=\"color: $color\">$risk_profile</h4>"; ?>

    <?php

        if ($risk>0) {
            echo "<h3>The reason is because:</h3>";
        }
        if ($age_risk) {
            echo "<li class=\"risk_reason\">You are older than 35 years old which are more prone to complications during pregnancy.</li>";
        }
        if ($miscarriage_risk) {
            echo "<li class=\"risk_reason\">You have experienced multiple miscarriages/stillbirths. This means you have a higher chance of miscarrying again.</li>";
        }
        if ($weight_risk) {
            if ($weight_risk_detail == "over") {
                echo "<li class=\"risk_reason\">Your weight gain is higher than the normal range.</li>";
            } else {
                echo "<li class=\"risk_reason\">Your weight gain is lower than the normal range.</li>";
            }
        }
        if ($bp_risk) {
            echo "<li class=\"risk_reason\">Your blood pressure is higher than what is considered normal.</li>";
        }
        if ($hb_risk) {
            echo "<li class=\"risk_reason\">Your haemoblogin level indicates that you are anemic.</li>";
        }
        if ($bs_risk) {
            echo "<li class=\"risk_reason\">Your blood sugar level is higher than what is considered normal during a pregnancy.</li>";
        }
    ?>

    <div class="content_selections">
        <div class="containers">
            <a href="landing_page.html">
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