

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/supervisor.css">
    <title>Project Events</title>
    <style>
        .worker-events-header {
             margin-top:40px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .worker-events-header h2 {
            margin: 0;
            color: #2c3e50;
        }

        .project-id-card {
    background: linear-gradient(135deg, #f0fff4 0%, #ffffff 100%);
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 16px;
    cursor: pointer;
    border-left: 6px solid #2e7d32;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}

.project-id-card:hover {
    background: #e8f5e9;
    transform: translateY(-3px);
}

.project-id-header {
    
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.project-id-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.event-date-label {
    font-size: 0.85rem;
    color: #2e7d32;
    font-weight: 500;
    background-color: #d0f0da;
    padding: 4px 8px;
    border-radius: 20px;
    margin-right: 8px;
}

        .event-details-container {
            display: none;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #ddd;
        }

        .worker-events-list {
            max-height: 500px;
            overflow-y: auto;
            padding-right: 8px;
        }

        .worker-event-card {
            margin-bottom: 8px;
            background-color: white;
            padding: 8px;
            border-radius: 5px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .worker-event-icon {
            display: inline-block;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            background-color: #e8f5e9;
            color: #4CAF50;
            border-radius: 50%;
            margin-right: 10px;
        }

        .worker-event-details {
            display: inline-block;
            vertical-align: top;
            width: calc(100% - 45px);
        }

        .worker-event-header h3 {
            margin: 0 0 5px 0;
            font-size: 0.9rem;
        }

        .worker-event-info {
            display: flex;
            flex-wrap: wrap;
            font-size: 0.8rem;
            color: #555;
        }

        .worker-event-info span {
            margin-right: 10px;
            margin-bottom: 5px;
        }

        .active-project {
    background-color: #d4edda;
    border-left: 6px solid #1b5e20;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
}


        .expand-icon {
    font-size: 0.9rem;
    color: #2e7d32;
    transition: transform 0.3s ease;
    margin-left: 4px;
}

.rotate-icon {
    transform: rotate(180deg);
}

.event-details-container {
    display: none;
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px dashed #b2dfdb;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}
.add-event-button {
    background-color: #2e7d32;
    color: white;
    border: none;
    padding: 8px 16px;
    font-size: 0.95rem;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.add-event-button:hover {
    background-color: #27632a;
}
#add-event-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #ffffff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            width: 100%;
            max-width: 500px;
            animation: fadeIn 0.3s ease-in-out;
        }

        #add-event-form h3 {
            margin-bottom: 20px;
            font-size: 1.4rem;
            color: #2c3e50;
        }

        #add-event-form form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        #add-event-form label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        #add-event-form input {
            padding: 10px 12px;
            font-size: 0.9rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: border-color 0.3s ease;
        }

        #add-event-form input:focus {
            border-color: #2e7d32;
            outline: none;
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
        }

        #add-event-form button {
            padding: 10px 16px;
            font-size: 0.95rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #add-event-form button[type="button"]:first-of-type {
            background-color: #2e7d32;
            color: white;
        }

        #add-event-form button[type="button"]:first-of-type:hover {
            background-color: #27632a;
        }

        #add-event-form button[type="button"]:last-of-type {
            background-color: #f5f5f5;
            color: #333;
        }

        #add-event-form button[type="button"]:last-of-type:hover {
            background-color: #e0e0e0;
        }

        #form-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 999;
        }
        #add-event-form textarea {
    padding: 10px 12px;
    font-size: 0.9rem;
    border: 1px solid #ccc;
    border-radius: 6px;
    transition: border-color 0.3s ease;
    width: 100%;
    resize: vertical; /* Allows resizing the height */
}

#add-event-form textarea:focus {
    border-color: #2e7d32;
    outline: none;
    box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
}

    </style>
</head>

<body>
	<?php
	require ROOT . '/views/supervisor/sidebar.php';
	require ROOT . '/views/components/topbar.php';
	?>
	<div id="event-schedule-section" class="section">
		<div class="worker-events-container">
			<div class="worker-events-header">
				<h2><i class="fas fa-calendar-check"></i> Today's Events</h2>
				<span class="current-date"><?= date("F j, Y") ?></span>
			</div>
			<div class="worker-events-list">
				<!-- Event Cards -->
				<div class="worker-event-card">
					<div class="worker-event-icon">
						<i class="fas fa-leaf"></i>
					</div>
					<div class="worker-event-details">
						<div class="worker-event-header">
							<h3>Land Clearing</h3>
						</div>
						<div class="worker-event-info">
							<span><i class="fas fa-clock"></i> 09:00 AM</span>
							<span><i class="fas fa-map-pin"></i> Field A, No. 12, Green Valley Road</span>
							<span><i class="fas fa-user"></i> Ruwan Fernando</span>
						</div>
					</div>
				</div>
				<div class="worker-event-card">
					<div class="worker-event-icon">
						<i class="fas fa-vial"></i>
					</div>
					<div class="worker-event-details">
						<div class="worker-event-header">
							<h3>Soil Testing</h3>
						</div>
						<div class="worker-event-info">
							<span><i class="fas fa-clock"></i> 11:00 AM</span>
							<span><i class="fas fa-map-pin"></i> Lab 1, No. 45, Orchard Street</span>
							<span><i class="fas fa-user"></i> Priyanka Silva</span>
						</div>
					</div>
				</div>
				<div class="worker-event-card">
					<div class="worker-event-icon">
						<i class="fas fa-seedling"></i>
					</div>
					<div class="worker-event-details">
						<div class="worker-event-header">
							<h3>Fertilizing</h3>
						</div>
						<div class="worker-event-info">
							<span><i class="fas fa-clock"></i> 01:00 PM</span>
							<span><i class="fas fa-map-pin"></i> Field B, No. 89, Sunset Avenue</span>
							<span><i class="fas fa-user"></i> Saman Kumara</span>
						</div>
					</div>
				</div>
				<div class="worker-event-card">
					<div class="worker-event-icon">
						<i class="fas fa-seedling"></i>
					</div>
					<div class="worker-event-details">
						<div class="worker-event-header">
							<h3>Seed Sowing</h3>
						</div>
						<div class="worker-event-info">
							<span><i class="fas fa-clock"></i> 03:00 PM</span>
							<span><i class="fas fa-map-pin"></i> Field C, No. 7, Maple Lane</span>
							<span><i class="fas fa-user"></i> Nuwan Perera</span>
						</div>
					</div>
				</div>
				<div class="worker-event-card">
					<div class="worker-event-icon">
						<i class="fas fa-tractor"></i>
					</div>
					<div class="worker-event-details">
						<div class="worker-event-header">
							<h3>Harvesting</h3>
						</div>
						<div class="worker-event-info">
							<span><i class="fas fa-clock"></i> 05:00 PM</span>
							<span><i class="fas fa-map-pin"></i> Field D, No. 23, Sunshine Road</span>
							<span><i class="fas fa-user"></i> Chaminda Karunaratne</span>
						</div>
					</div>
				</div>
				<div class="worker-event-card">
					<div class="worker-event-icon">
						<i class="fas fa-box"></i>
					</div>
					<div class="worker-event-details">
						<div class="worker-event-header">
							<h3>Processing the Harvest</h3>
						</div>
						<div class="worker-event-info">
							<span><i class="fas fa-clock"></i> 07:00 PM</span>
							<span><i class="fas fa-map-pin"></i> Processing Unit, No. 5, Industrial Park</span>
							<span><i class="fas fa-user"></i> Kusal Jayawardena</span>
						</div>
					</div>
				</div>
				<div class="worker-event-card">
					<div class="worker-event-icon">
						<i class="fas fa-broom"></i>
					</div>
					<div class="worker-event-details">
						<div class="worker-event-header">
							<h3>Weeding</h3>
						</div>
						<div class="worker-event-info">
							<span><i class="fas fa-clock"></i> 08:00 AM</span>
							<span><i class="fas fa-map-pin"></i> Field E, No. 37, Evergreen Lane</span>
							<span><i class="fas fa-user"></i> Ashoka Rathnayake</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>