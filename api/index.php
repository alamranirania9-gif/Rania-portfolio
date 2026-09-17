<?php
// Directory where uploaded images will be saved
$uploadDir = 'uploads/';

// Create the directory if it doesn't exist
if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true);}

$message = '';

// Handle Image Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $file = $_FILES['photo'];
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        
        if (in_array($file['type'], $allowedTypes)) {
            // Generate a unique filename to prevent overwriting
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid('girly_', true) . '.' . $ext;
            $destination = $uploadDir . $filename;
            
            if (move_uploaded_filename($file['tmp_name'], $destination)) {
                $message = "✨ Photo uploaded successfully!";
            } else {
                $message = "❌ Failed to save the photo.";
            }
        } else {
            $message = "❌ Only JPG, PNG, GIF, and WEBP formats are allowed.";
        }
    } else {
        $message = "❌ Please select a valid photo to upload.";
    }
}

// Fetch all uploaded photos
$photos = glob($uploadDir . '*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
rsort($photos); // Show newest uploads first
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Lovely Gallery ✨</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Sacramento&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-pink: #ffb6c1;
            --soft-pink: #fff0f5;
            --accent-pink: #ff69b4;
            --text-color: #5a4b5c;
            --card-bg: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--soft-pink);
            color: var(--text-color);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            text-align: center;
            padding: 40px 20px 20px;
        }

        h1 {
            font-family: 'Sacramento', cursive;
            font-size: 3.5rem;
            color: var(--accent-pink);
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.05);
        }

        p.subtitle {
            font-size: 1rem;
            color: #8a738c;
            margin-top: 5px;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin-bottom: 50px;
        }

        .upload-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(255, 182, 193, 0.3);
            text-align: center;
            margin-bottom: 40px;
            border: 2px dashed var(--primary-pink);
        }

        .upload-card h2 {
            margin-top: 0;
            font-size: 1.4rem;
            color: var(--accent-pink);
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        input[type="file"] {
            display: none;
        }

        .custom-file-upload {
            background-color: var(--soft-pink);
            color: var(--accent-pink);
            padding: 10px 20px;
            border-radius: 25px;
            border: 1px solid var(--primary-pink);
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .custom-file-upload:hover {
            background-color: var(--primary-pink);
            color: white;
        }

        button[type="submit"] {
            background-color: var(--accent-pink);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(255, 105, 180, 0.4);
            transition: transform 0.2s ease, background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            background-color: #ff1493;
        }

        .alert-message {
            margin-top: 15px;
            font-weight: bold;
            color: var(--accent-pink);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            background: var(--card-bg);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            padding: 10px;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover {
            transform: scale(1.03);
        }

        .gallery-item img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 10px;
        }

        .empty-gallery {
            text-align: center;
            grid-column: 1 / -1;
            color: #b09bb3;
            font-style: italic;
        }
    </style>
</head>
<body>

    <header>
        <h1>Welcome to My World 💕</h1>
        <p class="subtitle">A cute space to capture and share memory moments ✨</p>
    </header>

    <div class="container">
        <!-- Photo Upload Box -->
        <div class="upload-card">
            <h2>Add a New Memory 🌸</h2>
            <form action="index.php" method="POST" enctype="multipart/form-data">
                <label for="photo" class="custom-file-upload">
                    🎀 Choose Photo
                </label>
                <input type="file" id="photo" name="photo" accept="image/*" required onchange="updateFileName(this)">
                <span id="file-name" style="font-size: 0.85rem; color: #8a738c;">No file selected</span>
                
                <button type="submit">Upload ✨</button>
            </form>

            <?php if (!empty($message)): ?>
                <div class="alert-message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
        </div>

        <!-- Photo Gallery -->
        <div class="gallery-grid">
            <?php if (!empty($photos)): ?>
                <?php foreach ($photos as $photo): ?>
                    <div class="gallery-item">
                        <img src="<?php echo htmlspecialchars($photo); ?>" alt="Girly Uploaded Photo">
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-gallery">No photos uploaded yet. Add your first photo above! 💖</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileNameSpan = document.getElementById('file-name');
            if (input.files && input.files.length > 0) {
                fileNameSpan.textContent = input.files[0].name;
            } else {
                fileNameSpan.textContent = 'No file selected';
            }
        }
    </script>
</body>
</html>