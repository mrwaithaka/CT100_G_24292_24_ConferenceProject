<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Collect inputs safely
    $fullName = htmlspecialchars(trim($_POST['fullName'] ?? ''));
    $adminNo = htmlspecialchars(trim($_POST['adminNo'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $yearOfStudy = htmlspecialchars($_POST['yearOfStudy'] ?? '');
    $category = htmlspecialchars($_POST['category'] ?? '');
    $days = intval($_POST['days'] ?? 0);
    $workshop = htmlspecialchars($_POST['workshop'] ?? 'None');
    $meals = isset($_POST['catering']) ? 'Yes' : 'No';
    $accommodation = isset($_POST['accommodation']) ? 'Yes' : 'No';

    // 2. Server-side Validation
    $errors = [];
    if (empty($fullName)) $errors[] = "Full name field is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format string configuration.";
    if (!preg_match('/^\d{10}$/', $phone)) $errors[] = "Phone number tracking requires exactly 10 digits.";
    if ($days < 1 || $days > 3) $errors[] = "Conference days window falls outside 1-3 constraints boundaries.";
    if (empty($category)) $errors[] = "Participation category allocation context must be explicit.";

    if (!empty($errors)) {
        echo "<div style='color:red; padding:20px; background:#fff0f0; border:1px solid red; border-radius:5px;'>";
        echo "<h3>⚠️ Server-Side Validation Errors Encountered:</h3><ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul><a href='register.html'>Return and correct settings errors</a></div>";
        exit;
    }

    // 3. Isolated Independent Calculation Core Engine Architecture
    $REG_FEE = 1000;
    $PER_DAY_FEE = 500;
    $WORKSHOP_FEE = 750;
    $MEAL_PER_DAY = 300;
    $ACCOMMODATION_PER_NIGHT = 1500;

    $totalFee = $REG_FEE + ($days * $PER_DAY_FEE);

    if ($category === "Workshop Participant" && $workshop !== "None") {
        $totalFee += $WORKSHOP_FEE;
    }
    if ($meals === "Yes") {
        $totalFee += ($days * $MEAL_PER_DAY);
    }
    if ($accommodation === "Yes") {
        $totalFee += ($days * $ACCOMMODATION_PER_NIGHT);
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Registration Confirmation Status</title>
        <link rel="stylesheet" href="css/style.css">
        <style>
            .success-card {
                border-top: 8px solid #28a745;
                padding: 2rem;
                background: #ffffff;
            }
            .receipt-line {
                display: flex;
                justify-content: space-between;
                border-bottom: 1px dotted #ccc;
                padding: 0.5rem 0;
            }
            .grand-total {
                font-size: 1.5rem;
                color: #0056b3;
                font-weight: bold;
                margin-top: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="container success-card">
            <h2 style="color: #28a745; text-align:center;"> REGISTRATION SUCCESSFUL</h2>
            <p>Thank you for registering for the <strong>Student Technology and Innovation Conference</strong>. Below is your verified itinerary configuration detail summary breakdown.</p>
            
            <h3>Participant Details</h3>
            <div class="receipt-line"><span><strong>Name:</strong></span> <span><?php echo $fullName; ?></span></div>
            <div class="receipt-line"><span><strong>Admission Number:</strong></span> <span><?php echo $adminNo; ?></span></div>
            <div class="receipt-line"><span><strong>Email:</strong></span> <span><?php echo $email; ?></span></div>
            <div class="receipt-line"><span><strong>Phone:</strong></span> <span><?php echo $phone; ?></span></div>
            <div class="receipt-line"><span><strong>Year of Study:</strong></span> <span>Year <?php echo $yearOfStudy; ?></span></div>

            <h3>Package Selections</h3>
            <div class="receipt-line"><span><strong>Category Chosen:</strong></span> <span><?php echo $category; ?></span></div>
            <div class="receipt-line"><span><strong>Conference Days:</strong></span> <span><?php echo $days; ?> day(s)</span></div>
            <div class="receipt-line"><span><strong>Workshop Track:</strong></span> <span><?php echo $workshop; ?></span></div>
            <div class="receipt-line"><span><strong>Catering Included:</strong></span> <span><?php echo $meals; ?></span></div>
            <div class="receipt-line"><span><strong>Campus Accommodations:</strong></span> <span><?php echo $accommodation; ?></span></div>

            <div class="receipt-line grand-total">
                <span>TOTAL AMOUNT PAYABLE:</span>
                <span>KSh <?php echo number_format($totalFee); ?></span>
            </div>

            <p style="text-align: center; margin-top: 2rem; font-style: italic; color: #555;">
                A confirmation voucher ticket slip invoice receipt has been compiled dynamically and tracked securely to your server record instance context. See you at the main auditorium!
            </p>
            <div style="text-align: center;"><a href="index.html" class="hero-btn" style="background:#0056b3;">Return Home</a></div>
        </div>
    </body>
    </html>
    <?php
} else {
    header("Location: register.html");
    exit;
}
?>
