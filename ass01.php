<!DOCTYPE html>
<html>
<head>
    <title>AES-256-CBC Encryption</title>
</head>
<body>
    <h1>AES-256-CBC Encryption System</h1>
    <p>University Assignment</p>
    
    <form method="post" action="">
        <div>
            <label>Text to process:</label><br>
            <textarea name="text" rows="10" cols="80"><?php 
                if(isset($_POST['text'])) {
                    echo htmlspecialchars($_POST['text']);
                }
            ?></textarea>
        </div>
        <br>
        <div>
            <input type="submit" name="encrypt" value="Encrypt">
            <input type="submit" name="decrypt" value="Decrypt">
            <button type="button" onclick="clearForm()">Clear</button>
        </div>
    </form>
    
    <?php
    $key = 'my_simple_key_1234567890123456';
    $iv = '1234567890123456';
    
    if(strlen($key) != 32) {
        echo '<p>Error: Key must be 32 characters</p>';
    }
    
    if(strlen($iv) != 16) {
        echo '<p>Error: IV must be 16 characters</p>';
    }
    
    if(isset($_POST['encrypt']) && !empty($_POST['text'])) {
        $plaintext = $_POST['text'];
        $ciphertext = openssl_encrypt($plaintext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        
        if($ciphertext === false) {
            echo '<p>Error in encryption</p>';
        } else {
            $encrypted_base64 = base64_encode($ciphertext);
            echo '<h3>Encrypted Text (Base64):</h3>';
            echo '<textarea rows="5" cols="80">' . htmlspecialchars($encrypted_base64) . '</textarea>';
        }
    }
    
    if(isset($_POST['decrypt']) && !empty($_POST['text'])) {
        $encrypted_text = $_POST['text'];
        $ciphertext = base64_decode($encrypted_text);
        
        if($ciphertext === false) {
            echo '<p>Error: Not valid Base64</p>';
        } else {
            $decrypted_text = openssl_decrypt($ciphertext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
            
            if($decrypted_text === false) {
                echo '<p>Error in decryption</p>';
            } else {
                echo '<h3>Decrypted Text:</h3>';
                echo '<textarea rows="5" cols="80">' . htmlspecialchars($decrypted_text) . '</textarea>';
            }
        }
    }
    
    if((isset($_POST['encrypt']) || isset($_POST['decrypt'])) && empty($_POST['text'])) {
        echo '<p>Please enter text first</p>';
    }
    ?>
    
    <script>
        function clearForm() {
            document.querySelector('textarea[name="text"]').value = '';
        }
    </script>
</body>
</html>