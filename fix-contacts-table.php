<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/config.php';

echo "<h1>🔧 Diagnostic et Réparation de la Table Contacts</h1>";

// 1. Vérifier si la table existe
echo "<h2>1️⃣ Vérification de l'existence de la table</h2>";
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'contacts'");
    $exists = $stmt->fetch();
    
    if ($exists) {
        echo "✅ La table 'contacts' existe<br>";
    } else {
        echo "❌ La table 'contacts' n'existe PAS<br>";
        echo "<p>Cliquez sur le bouton ci-dessous pour la créer :</p>";
        
        if (isset($_GET['create'])) {
            $sql = "CREATE TABLE contacts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                subject VARCHAR(200),
                message TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            
            $pdo->exec($sql);
            echo "✅ Table créée avec succès ! <a href='fix-contacts-table.php'>Actualiser</a><br>";
        } else {
            echo "<a href='?create=1' style='padding: 10px; background: green; color: white; text-decoration: none;'>CRÉER LA TABLE</a>";
        }
        exit;
    }
} catch(PDOException $e) {
    die("❌ Erreur : " . $e->getMessage());
}

// 2. Afficher la structure actuelle
echo "<h2>2️⃣ Structure actuelle de la table</h2>";
try {
    $stmt = $pdo->query("DESCRIBE contacts");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr style='background: #f0f0f0;'><th>Colonne</th><th>Type</th><th>Null</th><th>Clé</th><th>Défaut</th></tr>";
    
    $expected = ['id', 'name', 'email', 'subject', 'message', 'created_at'];
    $actual = array_column($columns, 'Field');
    
    foreach ($columns as $col) {
        $style = in_array($col['Field'], $expected) ? '' : 'background: #ffcccc;';
        echo "<tr style='$style'>";
        echo "<td><strong>{$col['Field']}</strong></td>";
        echo "<td>{$col['Type']}</td>";
        echo "<td>{$col['Null']}</td>";
        echo "<td>{$col['Key']}</td>";
        echo "<td>{$col['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Vérifier les colonnes manquantes
    $missing = array_diff($expected, $actual);
    $extra = array_diff($actual, $expected);
    
    if (count($missing) > 0) {
        echo "<h3 style='color: red;'>❌ Colonnes manquantes :</h3>";
        echo "<ul>";
        foreach ($missing as $col) {
            echo "<li><strong>$col</strong></li>";
        }
        echo "</ul>";
    }
    
    if (count($extra) > 0) {
        echo "<h3 style='color: orange;'>⚠ Colonnes en trop :</h3>";
        echo "<ul>";
        foreach ($extra as $col) {
            if ($col != 'id') {
                echo "<li><strong>$col</strong></li>";
            }
        }
        echo "</ul>";
    }
    
    if (count($missing) == 0 && count($extra) == 0) {
        echo "<h3 style='color: green;'>✅ Structure parfaite !</h3>";
    }
    
} catch(PDOException $e) {
    die("❌ Erreur : " . $e->getMessage());
}

// 3. Proposer une réparation
if (count($missing) > 0 || count($extra) > 0) {
    echo "<h2>3️⃣ Réparation</h2>";
    echo "<p><strong>Option 1 :</strong> Recréer la table (supprime les données existantes)</p>";
    
    if (isset($_GET['recreate'])) {
        try {
            $pdo->exec("DROP TABLE IF EXISTS contacts");
            $pdo->exec("CREATE TABLE contacts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                subject VARCHAR(200),
                message TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
            
            echo "<div style='padding: 20px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; margin: 10px 0;'>";
            echo "✅ Table recréée avec succès ! <a href='fix-contacts-table.php'>Actualiser</a>";
            echo "</div>";
        } catch(PDOException $e) {
            echo "<div style='padding: 20px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 10px 0;'>";
            echo "❌ Erreur : " . $e->getMessage();
            echo "</div>";
        }
    } else {
        echo "<a href='?recreate=1' onclick='return confirm(\"⚠ ATTENTION : Cela va supprimer toutes les données existantes. Continuer ?\")' style='padding: 10px 20px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 0;'>RECRÉER LA TABLE</a>";
    }
}

// 4. Test d'insertion
echo "<h2>4️⃣ Test d'insertion</h2>";

if (isset($_GET['test'])) {
    try {
        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute(['Test User', 'test@example.com', 'Test Subject', 'Test Message']);
        
        if ($result) {
            $lastId = $pdo->lastInsertId();
            echo "<div style='padding: 20px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px;'>";
            echo "✅ Test d'insertion réussi ! ID : $lastId<br>";
            echo "Les données sont bien enregistrées en base.<br>";
            echo "<a href='fix-contacts-table.php'>Actualiser</a>";
            echo "</div>";
        }
    } catch(PDOException $e) {
        echo "<div style='padding: 20px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px;'>";
        echo "❌ Erreur lors du test : " . $e->getMessage();
        echo "</div>";
    }
} else {
    echo "<a href='?test=1' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; display: inline-block;'>TESTER UNE INSERTION</a>";
}

// 5. Afficher le contenu
echo "<h2>5️⃣ Contenu actuel de la table</h2>";
try {
    $stmt = $pdo->query("SELECT * FROM contacts ORDER BY id DESC LIMIT 10");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($contacts) > 0) {
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'>";
        foreach (array_keys($contacts[0]) as $header) {
            echo "<th>$header</th>";
        }
        echo "</tr>";
        
        foreach ($contacts as $contact) {
            echo "<tr>";
            foreach ($contact as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<p><em>Affichage des 10 derniers enregistrements</em></p>";
    } else {
        echo "<p>⚠ La table est vide</p>";
    }
} catch(PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
?>