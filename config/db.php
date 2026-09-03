<?php
/**
 * KasurCanvas.com - Database Connection & Auto-Initialization Engine
 * A modern venture of SabriTextiles.com
 */

// Load production configuration if present (ignored by git for security)
if (file_exists(__DIR__ . '/db_config.php')) {
    require_once __DIR__ . '/db_config.php';
}

// Global Configuration (Default Local Fallback)
defined('DB_HOST') || define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
defined('DB_PORT') || define('DB_PORT', getenv('DB_PORT') ?: '3306');
defined('DB_NAME') || define('DB_NAME', getenv('DB_NAME') ?: 'kasurcanvas_db');
defined('DB_USER') || define('DB_USER', getenv('DB_USER') ?: 'root');
defined('DB_PASS') || define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');

// Site Metadata
define('SITE_NAME', 'Kasur Canvas');
define('SITE_TAGLINE', 'Premier Industrial & Heavy-Duty Canvas Manufacturers');
define('PARENT_COMPANY', 'Sabri Textiles');
define('PARENT_URL', 'https://sabritextiles.com');
define('COMPANY_PHONE', '+92 300 944 6654');
define('COMPANY_PHONE_RAW', '923009446654');
define('COMPANY_EMAIL', 'info@kasurcanvas.com');
define('COMPANY_ADDRESS', 'Main Nimazpura Road, Kasur - Punjab, Pakistan');

/**
 * Automatically determine the base URL whether hosted at /kasurcanvas or root /
 */
function base_url($path = '') {
    static $base = null;
    if ($base === null) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        
        // Detect subfolder in URL
        $subfolder = '';
        if (strpos($scriptName, '/kasurcanvas') !== false) {
            $subfolder = '/kasurcanvas';
        }
        
        $base = $protocol . $host . $subfolder;
    }
    return rtrim($base, '/') . '/' . ltrim($path, '/');
}

/**
 * Returns active PDO connection, creating database & tables if needed
 */
function get_db() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    try {
        $dsnDb = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        
        // Step 1: Attempt direct connection to target database first (Standard production & cPanel approach)
        try {
            $pdo = new PDO($dsnDb, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $eDirect) {
            // Step 2: Fallback for local development if database does not exist yet
            $dsnInitial = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4";
            $pdoInit = new PDO($dsnInitial, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            $pdoInit->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $pdo = new PDO($dsnDb, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        // Step 3: Ensure tables and initial dataset exist
        init_schema_and_seed($pdo);

        return $pdo;
    } catch (PDOException $e) {
        die("<div style='font-family:sans-serif;padding:30px;background:#fee2e2;color:#991b1b;border-radius:8px;max-width:600px;margin:50px auto;'>
            <h3 style='margin-top:0'>Database Initialization Error</h3>
            <p>Could not connect to MySQL server. Please verify database credentials in config/db_config.php.</p>
            <p><small>" . htmlspecialchars($e->getMessage()) . "</small></p>
        </div>");
    }
}

/**
 * Creates schema and seeds all products and multi-images
 */
function init_schema_and_seed(PDO $pdo) {
    // 1. Categories Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `categories` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `slug` VARCHAR(80) NOT NULL UNIQUE,
        `name` VARCHAR(120) NOT NULL,
        `description` TEXT,
        `display_order` INT DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 2. Products Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `products` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `category_id` INT DEFAULT 1,
        `slug` VARCHAR(120) NOT NULL UNIQUE,
        `title` VARCHAR(200) NOT NULL,
        `subtitle` VARCHAR(255) DEFAULT '',
        `badge_text` VARCHAR(60) DEFAULT '',
        `short_desc` TEXT NOT NULL,
        `full_desc` LONGTEXT NOT NULL,
        `weight_spec` VARCHAR(150) DEFAULT '',
        `width_spec` VARCHAR(150) DEFAULT '',
        `yarn_spec` VARCHAR(150) DEFAULT '',
        `weave_spec` VARCHAR(150) DEFAULT '',
        `finish_spec` VARCHAR(150) DEFAULT '',
        `tensile_spec` VARCHAR(150) DEFAULT '',
        `applications` TEXT,
        `features` TEXT,
        `is_featured` TINYINT(1) DEFAULT 0,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 3. Product Images Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `product_images` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `product_id` INT NOT NULL,
        `image_url` VARCHAR(255) NOT NULL,
        `caption` VARCHAR(200) DEFAULT '',
        `is_primary` TINYINT(1) DEFAULT 0,
        `display_order` INT DEFAULT 0,
        FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 4. Inquiries Table (for RFQs and Contact Form)
    $pdo->exec("CREATE TABLE IF NOT EXISTS `inquiries` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `product_name` VARCHAR(150) DEFAULT 'General Inquiry',
        `customer_name` VARCHAR(120) NOT NULL,
        `company_name` VARCHAR(150) DEFAULT '',
        `email` VARCHAR(150) NOT NULL,
        `phone` VARCHAR(80) DEFAULT '',
        `country` VARCHAR(100) DEFAULT 'Pakistan',
        `quantity` VARCHAR(100) DEFAULT '',
        `message` TEXT NOT NULL,
        `status` ENUM('new', 'in_review', 'quoted', 'completed') DEFAULT 'new',
        `ip_address` VARCHAR(50) DEFAULT '',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Check if products exist; if not, seed data
    $check = $pdo->query("SELECT COUNT(*) FROM `products`")->fetchColumn();
    if ($check > 0) {
        return;
    }

    // Seed Categories
    $categories = [
        ['slug' => 'duck-canvas', 'name' => 'Cotton Duck Canvas', 'desc' => 'High-density plain weave natural and dyed canvas', 'order' => 1],
        ['slug' => 'waterproof-waxed', 'name' => 'Waterproof & Waxed Canvas', 'desc' => 'Treated weather-proof and water-shedding canvas', 'order' => 2],
        ['slug' => 'industrial-technical', 'name' => 'Industrial & Technical Fabrics', 'desc' => 'Conveyor, mechanical, and heavy utility textiles', 'order' => 3],
        ['slug' => 'filtration-media', 'name' => 'Filtration Media Cloth', 'desc' => 'High-performance liquid and dry filtration fabrics', 'order' => 4],
        ['slug' => 'specialty-canvas', 'name' => 'Specialty & Heritage Weaves', 'desc' => 'Dosuti, Ripstop, and protective contractor textiles', 'order' => 5],
    ];

    $stmtCat = $pdo->prepare("INSERT INTO `categories` (`slug`, `name`, `description`, `display_order`) VALUES (?, ?, ?, ?)");
    foreach ($categories as $cat) {
        $stmtCat->execute([$cat['slug'], $cat['name'], $cat['desc'], $cat['order']]);
    }

    // Product definitions rewritten in own words based on Sabri Textiles canvas cloth matter
    $products = [
        [
            'cat_slug' => 'duck-canvas',
            'slug' => 'cotton-duck-canvas-fabric',
            'title' => 'Pure Cotton Duck Canvas Fabric',
            'subtitle' => 'Heavy-Duty 100% Virgin Cotton Plain-Weave Canvas (7oz - 28oz)',
            'badge' => 'Bestseller',
            'short_desc' => 'Manufactured with high-grade Pakistani combed cotton, our heavy-duty duck canvas offers superior tensile resilience, outstanding tear resistance, and a smooth, tightly woven face engineered for luggage, durable tents, artist boards, and rugged upholstery.',
            'full_desc' => "Crafted in our advanced Kasur manufacturing facility as part of Sabri Textiles' vertically integrated textile production, this premium Cotton Duck Canvas represents the gold standard of natural utility fabrics. 

Woven from 100% pure virgin ring-spun cotton fibers on high-speed shuttleless air-jet looms, each yard features a meticulously balanced warp-and-weft intersection that delivers extraordinary dimensional stability. The fabric resists high-load friction, cyclic folding, and severe mechanical tension while remaining completely breathable.

Whether left in its raw unbleached ecru tone for painters and eco-friendly tote manufacturers, or reactive-dyed to custom industrial pantones, Kasur Canvas duck is pre-shrunk, scoured, and checked under strict ISO-compliant quality protocols. Custom GSM specifications, roll widths, and specialty fire-retardant or mildew-inhibiting treatments are available upon export request.",
            'weight' => '7 oz/yd² to 28 oz/yd² (240 GSM – 950 GSM)',
            'width' => '36 inches to 120 inches (up to 3.05 meters)',
            'yarn' => '10/2, 10/3, 7/2, 6/2, 4/2 ring-spun cotton',
            'weave' => 'Tight Plain Weave / Numbered Duck (Single & Plied)',
            'finish' => 'Natural Grey / Scoured / Bleached / Reactive Dyed',
            'tensile' => 'Warp: >1400 N | Weft: >1200 N (ASTM D5034)',
            'applications' => json_encode([
                'Heavy-duty military and humanitarian relief tents',
                'Premium duffle bags, tool rolls, and canvas backpacks',
                'Architectural awnings, indoor upholstery, and slipcovers',
                'High-end artist stretched canvas panels',
                'Industrial machinery insulation jackets and wraps'
            ]),
            'features' => json_encode([
                '100% Pure Virgin Cotton Ring-Spun Yarns',
                'Flawless High-Density Plain Weave Structure',
                'Exceptional Abrasion & Puncture Resistance',
                'Natural Breathability and Skin-Friendly Softness',
                'Custom Widths available up to 120 inches'
            ]),
            'is_featured' => 1,
            'images' => [
                ['url' => 'assets/images/products/cotton-duck-1.jpg', 'caption' => 'Premium Natural Cotton Duck Canvas Roll', 'is_primary' => 1],
                ['url' => 'assets/images/products/cotton-duck-2.jpg', 'caption' => 'High-Density Warp & Weft Yarn Weave Detail', 'is_primary' => 0],
                ['url' => 'assets/images/products/cotton-duck-3.jpg', 'caption' => 'Dyed and Natural Canvas Warehouse Inventory', 'is_primary' => 0],
            ]
        ],
        [
            'cat_slug' => 'waterproof-waxed',
            'slug' => 'waterproof-waxed-canvas-cloth',
            'title' => 'Heavy-Duty Waterproof Canvas Fabric',
            'subtitle' => 'Paraffin & Fluorocarbon Treated Weather-Resistant Textile',
            'badge' => 'Weatherproof',
            'short_desc' => 'Treated with cutting-edge hydrophobic emulsion and traditional wax formulation, this heavy-duty canvas creates an impenetrable barrier against torrential rain, moisture penetration, and mold without sacrificing rugged flexibility.',
            'full_desc' => "Engineered specifically to conquer demanding outdoor environments, Kasur Canvas Waterproof Fabric pairs heavy-weight cotton duck with our proprietary weatherproof impregnating bath. 

Unlike synthetic plastic tarpaulins that sweat and crack under scorching sunlight, our breathable wax-treated cotton fabric lets micro-humidity escape while preventing external water droplets from penetrating. Rain beads up and glides right off the exterior, making it the preferred choice for long-term outdoor camping expeditions, defense shelters, truck covers, and maritime applications.

Every batch undergoes stringent hydrostatic pressure head testing in our Kasur laboratory. It is chemically stabilized against UV degradation, rotting in wet climates, and fungal mildew growth. Available in army olive green, deep khaki, desert tan, navy blue, and slate grey.",
            'weight' => '12 oz/yd² to 24 oz/yd² (400 GSM – 820 GSM)',
            'width' => '48 inches to 96 inches',
            'yarn' => '10/2, 7/2, 6/2 heavy twisted cotton',
            'weave' => 'High-Density 2x2 Duck Weave',
            'finish' => 'Waxed / Hydrophobic PU Coating / Fluorocarbon / Water-Repellent',
            'tensile' => 'Hydrostatic Head: >800mm H2O | Tensile: >1600 N',
            'applications' => json_encode([
                'Commercial truck tarpaulins and trailer cargo covers',
                'Severe-weather disaster relief and military camping tents',
                'Marine boat covers, deck tarps, and sail covers',
                'Agricultural grain harvest protection covers',
                'Vintage motorcycle bags and outdoor waxed apparel'
            ]),
            'features' => json_encode([
                'Extreme Hydrophobic Water Beading Performance',
                'Mold, Rot & Mildew Resistant Chemical Impregnation',
                'UV-Stabilized Against Prolonged Sun Exposure',
                'Zero Delamination: Long-lasting deep fiber infusion',
                'Reinforced Selvage Edges for High-Tension Rigging'
            ]),
            'is_featured' => 1,
            'images' => [
                ['url' => 'assets/images/products/waterproof-canvas-1.jpg', 'caption' => 'Extreme Hydrophobic Water Droplet Beading on Olive Canvas', 'is_primary' => 1],
                ['url' => 'assets/images/products/waterproof-canvas-2.jpg', 'caption' => 'Heavy-Duty Reinforced Stitching and Solid Brass Grommets', 'is_primary' => 0],
                ['url' => 'assets/images/products/waterproof-canvas-3.jpg', 'caption' => 'Export-Ready Rolls of Waterproof Canvas Fabric', 'is_primary' => 0],
            ]
        ],
        [
            'cat_slug' => 'industrial-technical',
            'slug' => 'industrial-conveyor-belt-cloth',
            'title' => 'Industrial Conveyor Belt Canvas Cloth',
            'subtitle' => 'High-Tenacity Cotton & Polyester Hybrid Mechanical Reinforcement Duck',
            'badge' => 'Heavy Industrial',
            'short_desc' => 'Designed for severe mechanical friction and continuous rotational torque, our industrial conveyor belt canvas combines dense cotton cushioning with high-tenacity synthetic yarns for conveyor plies and transmission systems.',
            'full_desc' => "Conveyor Belt Canvas by Kasur Canvas represents advanced mechanical textile engineering. Built inside our specialized heavy-weaving sheds in Kasur, this structural ply cloth forms the internal tensile core of industrial rubber conveyor belts, elevator bucket belts, and mechanical power transmission straps.

By interweaving high-tenacity polyester filament yarns in the longitudinal warp with multi-ply long-staple cotton yarns in the cross weft, the fabric delivers minimal elongation under tension while retaining superior rubber adhesion and mechanical fastener holding capability. 

It exhibits supreme puncture resistance when handling coarse aggregates, ores, grain, or boxed freight. Specially heat-set and scoured to eliminate shrinkage variance and prevent belt delamination in continuous 24/7 conveyor operations.",
            'weight' => '18 oz/yd² to 36 oz/yd² (610 GSM – 1220 GSM)',
            'width' => '24 inches to 84 inches (Custom slit widths available)',
            'yarn' => 'High Tenacity EP (Polyester / Cotton) Plied Yarns',
            'weave' => 'Heavy Multi-Ply Industrial Duck Weave',
            'finish' => 'Heat-set, Scoured, RFL Rubber-Adhesion Ready',
            'tensile' => 'Warp: >3200 N | Weft: >2100 N | Elongation: <3.5%',
            'applications' => json_encode([
                'Rubber conveyor belts for cement, mining, and quarry plants',
                'Industrial bucket elevator belt reinforcement',
                'Flat mechanical power transmission belts',
                'Heavy-load packaging sorting lines and logistics hubs',
                'Agricultural harvester and baler belts'
            ]),
            'features' => json_encode([
                'Ultra-Low Elongation Under Continuous Heavy Load',
                'Exceptional Inter-Ply Rubber & PVC Adhesion Strength',
                'High Fatigue Life Under Repeated Drum Flexing',
                'Thermal Resistance to Frictional Heat Buildup',
                'Consistent Gauge and Roll Thickness Accuracy'
            ]),
            'is_featured' => 1,
            'images' => [
                ['url' => 'assets/images/products/conveyor-canvas-1.jpg', 'caption' => 'Heavy Industrial Multi-Ply Conveyor Canvas Roll in Facility', 'is_primary' => 1],
                ['url' => 'assets/images/products/conveyor-canvas-2.jpg', 'caption' => 'Cross-Section & Dense Multi-Twist Yarn Structure', 'is_primary' => 0],
            ]
        ],
        [
            'cat_slug' => 'specialty-canvas',
            'slug' => 'dosuti-double-yarn-cotton-cloth',
            'title' => 'Authentic Dosuti Cloth (Double Cotton Yarn)',
            'subtitle' => 'Traditional 2-Ply Warp & Weft Breathable Textile (Do-Suti)',
            'badge' => 'Pakistani Heritage',
            'short_desc' => 'Honoring Pakistan\'s storied textile heritage, Dosuti (meaning "Two-Thread") cloth pairs two yarns running simultaneously in warp and weft, yielding a supremely durable, breathable, and distinctively textured cotton fabric.',
            'full_desc' => "Named after the historic South Asian weaving tradition ('Do' meaning Two, 'Suti' meaning Cotton Threads), Dosuti Cloth has been manufactured in Kasur for generations. At Kasur Canvas, we have upgraded this authentic artisanal fabric with computerized loom accuracy while preserving its organic soul.

By running twin-plied yarns together in both the warp and weft directions, Dosuti achieves a unique double-density grid structure. It combines high tear resistance with an open, airy breathability that synthetic fabrics simply cannot replicate. 

It is extensively exported across South Asia, the Middle East, and Europe for industrial flour and grain sacks, rustic safari tent linings, durable workwear uniforms, traditional shoe linings, and utility bags. It softens delightfully with washing while remaining nearly impossible to rip.",
            'weight' => '8 oz/yd² to 16 oz/yd² (270 GSM – 540 GSM)',
            'width' => '36 inches to 72 inches',
            'yarn' => '10/1 x 10/1 Double or 12/2 Twin Plied Cotton',
            'weave' => 'Traditional Double-Yarn Plain Weave (2x2 Structure)',
            'finish' => 'Raw Ecru / Semi-Bleached / Dyed / Soft Finish',
            'tensile' => 'Warp: >950 N | Weft: >900 N',
            'applications' => json_encode([
                'Heavy-duty commercial flour, pulse, and grain packaging sacks',
                'Safari tent inner liners, luxury glamping curtains, and drapes',
                'Durable industrial uniforms, work aprons, and pocket linings',
                'Canvas espadrille and sneaker footwear internal lining',
                'Organic reusable shopping bags and tote carriers'
            ]),
            'features' => json_encode([
                'Authentic 2-Ply Double Yarn Warp and Weft Weaving',
                'High Air Permeability with Rugged Surface Strength',
                '100% Eco-Friendly Biodegradable Cotton Composition',
                'Softens with Use Without Structural Integrity Loss',
                'Natural Resistance to Fiber Slippage and Seam Puckering'
            ]),
            'is_featured' => 1,
            'images' => [
                ['url' => 'assets/images/products/dosuti-cloth-1.jpg', 'caption' => 'Authentic Unbleached Dosuti Double-Thread Cotton Bolt', 'is_primary' => 1],
                ['url' => 'assets/images/products/dosuti-cloth-2.jpg', 'caption' => 'Close-up Inspection of Double Yarn Construction', 'is_primary' => 0],
            ]
        ],
        [
            'cat_slug' => 'filtration-media',
            'slug' => 'industrial-filter-cloth-media',
            'title' => 'Precision Industrial Filter Cloth',
            'subtitle' => 'Engineered Pure Cotton, Polyester & Blended Liquid-Solid Separation Media',
            'badge' => 'High Precision',
            'short_desc' => 'Engineered for press filters, centrifuges, and rotary drum systems, our filter fabrics deliver exact micron pore ratings, high chemical resilience, and rapid filter cake discharge across chemical, mining, and food processing plants.',
            'full_desc' => "Backed by Sabri Textiles' 50+ year legacy in industrial filtration fabrics, Kasur Canvas manufactures high-precision filter media calibrated for critical solid-liquid and dry dust separation processes.

Available in 100% pure long-staple cotton, high-tenacity filament polyester, or specialized poly-cotton hybrid blends, each filter roll is woven under controlled yarn tension to ensure uniform micron porosity across every square inch. 

In wet slurry filtration (such as sugar juice clarification, chemical precipitation, effluent wastewater treatment, and mining mineral beneficiation), our fabrics offer smooth particle release, minimal blinding/clogging, and resistance to aggressive chemical slurries and thermal pressure cycles.",
            'weight' => '10 oz/yd² to 26 oz/yd² (340 GSM – 880 GSM)',
            'width' => '30 inches to 90 inches',
            'yarn' => 'Spun Cotton, Multifilament Polyester, Monofilament Hybrid',
            'weave' => 'Twill, Plain, and Satin Filter Weaves',
            'finish' => 'Heat-Set, Calendered Smooth Surface, Singed',
            'tensile' => 'Air Permeability: 5 - 250 L/dm²/min | Bursting: >3.2 MPa',
            'applications' => json_encode([
                'Plate and frame filter presses in sugar refineries and mills',
                'Municipal and industrial wastewater treatment plants',
                'Chemical, pharmaceutical, and dye pigment filtration',
                'Mining slurry dewatering and mineral recovery presses',
                'Food oil clarification and beverage manufacturing'
            ]),
            'features' => json_encode([
                'Precision-Calibrated Micron Porosity & High Flow Rates',
                'Smooth Calendered Finish for Instant Filter Cake Release',
                'Resistance to Acidic, Alkaline, and Hot Slurry Baths',
                'Zero Fiber Shedding in Sensitive Food and Pharma Media',
                'Custom Laser-Cut Filter Press Cloths with Hemmed Eyelets'
            ]),
            'is_featured' => 0,
            'images' => [
                ['url' => 'assets/images/products/filter-cloth-1.jpg', 'caption' => 'Cleanroom Grade Industrial Filter Cloth Media Roll', 'is_primary' => 1],
                ['url' => 'assets/images/products/filter-cloth-2.jpg', 'caption' => 'Micro-Porous Precision Weave Surface View', 'is_primary' => 0],
            ]
        ],
        [
            'cat_slug' => 'specialty-canvas',
            'slug' => 'canvas-drop-cloth-dust-sheet',
            'title' => 'AAA Grade Canvas Drop Cloth (Dust Sheet)',
            'subtitle' => 'Professional Contractor Grade 100% Cotton Painter Drop Sheets',
            'badge' => 'Contractor Grade',
            'short_desc' => 'Made from premium Triple-AAA duck canvas with double-stitched rot-resistant hems, our contractor drop cloths trap paint splatters, absorb spills instantly, and protect expensive hardwood and tile flooring during renovations.',
            'full_desc' => "Designed for commercial decorators, painters, and home renovation professionals, Kasur Canvas Drop Cloths are fabricated from durable 100% natural cotton canvas. Unlike hazardous plastic drop sheets that tear easily, create slip hazards, and let wet paint smear around, our heavy-gauge cotton canvas absorbs paint droplets immediately.

Every drop sheet features quadruple-fold perimeter hems sewn with heavy polyester thread to prevent fraying through dozens of commercial washing cycles. The heavy fabric drapes flat over furniture, stairs, and hardwood floors without curling at the corners.

Available in standard export sizes (6ft x 9ft, 9ft x 12ft, 12ft x 15ft, and long hallway runners) with private-label retail packaging available for international hardware and DIY retail chains.",
            'weight' => '6 oz, 8 oz, 10 oz, and 12 oz per square yard',
            'width' => 'Finished Sizes: 4x12ft, 4x15ft, 6x9ft, 9x12ft, 12x15ft',
            'yarn' => '100% Natural Unbleached Cotton',
            'weave' => 'Dense Seamless Plain Weave Duck',
            'finish' => 'Washed Natural / Double Folded Hems / No Odor',
            'tensile' => 'Heavy Tear Resistance | 100% Machine Washable',
            'applications' => json_encode([
                'Commercial painting, drywall, and plastering floor shielding',
                'Furniture dust draping during construction and remodeling',
                'DIY curtains, rustic outdoor tablecloths, and photo backdrops',
                'Automotive mechanic fender and seat grease covers',
                'Contractor jobsite entryway dirt control mats'
            ]),
            'features' => json_encode([
                'Super Absorbent Cotton Stops Wet Paint Tracking',
                'Heavyweight Non-Slip Fabric Stays Firmly in Place',
                'Quadruple-Fold Double Lockstitched Edge Hems',
                'Washable, Reusable, and Environmentally Sustainable',
                'Retail-Ready Barcoded Polybag Packaging Available'
            ]),
            'is_featured' => 0,
            'images' => [
                ['url' => 'assets/images/products/canvas-drop-cloth-1.jpg', 'caption' => 'Professional Grade Folded Canvas Drop Sheet with Paint Tools', 'is_primary' => 1],
                ['url' => 'assets/images/products/canvas-drop-cloth-2.jpg', 'caption' => 'Reinforced Double-Stitched Edge Hem Detail', 'is_primary' => 0],
            ]
        ],
        [
            'cat_slug' => 'specialty-canvas',
            'slug' => 'tactical-ripstop-canvas-fabric',
            'title' => 'High-Performance Tactical RipStop Canvas',
            'subtitle' => 'Crosshatch Reinforced Tear-Stopping Cotton-Poly Combat Textile',
            'badge' => 'Ultra Rugged',
            'short_desc' => 'Featuring a visible square grid of high-tenacity reinforcement threads interwoven throughout the base canvas, this tactical fabric halts punctures and rips in their tracks, engineered for extreme military, overland, and expedition applications.',
            'full_desc' => "When ordinary canvas falls short against barbed wire, rock abrasions, and extreme mechanical stress, Kasur Canvas Tactical RipStop delivers unmatched durability. 

Woven with a distinctive box-grid pattern where ultra-strong plied reinforcement cords cross at tight 5mm intervals, any accidental tear or puncture is stopped dead at the nearest grid seam. The fabric cannot propagate a rip even under tremendous hurricane wind shear.

Treated with fluorocarbon weather repelling agents and matte military-spec dyeing, it is trusted for heavy expedition luggage, 4WD rooftop overland tents, tactical vests, canopy sidewalls, and military rucksacks. Lightweight yet practically indestructible.",
            'weight' => '10 oz/yd² to 18 oz/yd² (340 GSM – 610 GSM)',
            'width' => '54 inches to 65 inches',
            'yarn' => 'Cotton / High-Tenacity Poly Blend with Core-Spun Grid',
            'weave' => 'Reinforced Crosshatch Square RipStop Grid',
            'finish' => 'Water Repellent (DWR), Anti-UV, Anti-Mildew, Matte Finish',
            'tensile' => 'Tear Strength: >240 N (Elmendorf) | Tensile: >1900 N',
            'applications' => json_encode([
                'Tactical military backpacks, pouches, and load-bearing gear',
                'Overland 4x4 vehicle rooftop tents and roll-out awnings',
                'Heavy-duty industrial protective work jackets and trousers',
                'Helicopter covers, aerospace cargo tarps, and field shelters',
                'Extreme mountaineering duffels and expedition hammocks'
            ]),
            'features' => json_encode([
                'Integrated Crosshatch Grid Halts Tears Instantly',
                'Superior Strength-to-Weight Ratio Over Plain Ducks',
                'Extreme Wind Shear and Abrasion Endurance',
                'Durable Water Repellent (DWR) Hydrophobic Finish',
                'Available in Olive Drab, Coyote Tan, Black, and Navy'
            ]),
            'is_featured' => 1,
            'images' => [
                ['url' => 'assets/images/products/ripstop-canvas-1.jpg', 'caption' => 'Tactical Olive RipStop Canvas Bolt with Grid Weave Pattern', 'is_primary' => 1],
                ['url' => 'assets/images/products/ripstop-canvas-2.jpg', 'caption' => 'Macro Close-Up of Crosshatch High-Tenacity Reinforced Grid', 'is_primary' => 0],
                ['url' => 'assets/images/products/ripstop-canvas-3.jpg', 'caption' => 'High Capacity Canvas Warehouse Finished Stocks', 'is_primary' => 0],
            ]
        ],
        [
            'cat_slug' => 'industrial-technical',
            'slug' => 'cabinet-roll-towels-crt-fabric',
            'title' => 'Continuous Roll Toweling (CRT) Fabric',
            'subtitle' => 'Commercial Grade 100% Loop-Cotton Roll Hand-Drying Textile',
            'badge' => 'Commercial Hygiene',
            'short_desc' => 'Engineered for commercial washroom roller dispensers, this heavy continuous cotton toweling delivers superior water absorption, high laundry turn endurance, and lint-free hand drying for high-traffic institutions.',
            'full_desc' => "Part of Sabri Textiles' specialty toweling and canvas export lines, our Cabinet Roll Towel (CRT) fabric is woven for the international commercial hygiene and linen rental sector.

Engineered to endure 80+ aggressive commercial wash cycles, this 100% cotton fabric features specialized low-lint loop structures and reinforced selvages that feed smoothly through mechanical and automatic cabinet towel dispensers. 

Colored boundary identification stripes (blue or red yarn edge markers) facilitate sorting and inspection in commercial laundries. It delivers a much more sustainable, waste-free, and luxurious hand-drying experience than disposable paper towels.",
            'weight' => '7.5 oz/yd² to 11 oz/yd² (250 GSM – 380 GSM)',
            'width' => '10.5 inches to 12.5 inches (Standard Cabinet Roll Widths)',
            'yarn' => '100% Combed Cotton Ring Spun Yarns',
            'weave' => 'Engineered Absorbent Textured Towel Weave with Selvage Locks',
            'finish' => 'Optic Bleached White with Colored ID Border Stripes',
            'tensile' => 'Wash Durability: >80 Commercial High-Temp Cycles',
            'applications' => json_encode([
                'Commercial washroom roller cabinet towel dispensers',
                'Industrial linen rental and contract laundering operations',
                'Hospital, laboratory, and clean manufacturing hand hygiene',
                'Heavy-duty industrial wiping and tool drying rolls'
            ]),
            'features' => json_encode([
                'Instant Water Absorbency from First Touch',
                'Ultra-Low Lint Release During Roller Feeding',
                'Heavy Commercial Wash Life Cycle Endurance',
                'Precision Slit and Clean Bound Selvages Prevent Jams',
                'Colored Woven ID Marker Threads for Laundry Sorting'
            ]),
            'is_featured' => 0,
            'images' => [
                ['url' => 'assets/images/products/continuous-roll-towel-1.jpg', 'caption' => 'Stacked Commercial Continuous Roll Towel Bolts with Blue Edge', 'is_primary' => 1],
                ['url' => 'assets/images/products/continuous-roll-towel-2.jpg', 'caption' => 'High-Absorbency Woven Cotton Loop Structure', 'is_primary' => 0],
            ]
        ]
    ];

    // Prepare insert statements
    $stmtProd = $pdo->prepare("INSERT INTO `products` 
        (`category_id`, `slug`, `title`, `subtitle`, `badge_text`, `short_desc`, `full_desc`, `weight_spec`, `width_spec`, `yarn_spec`, `weave_spec`, `finish_spec`, `tensile_spec`, `applications`, `features`, `is_featured`) 
        VALUES 
        ((SELECT id FROM categories WHERE slug = ?), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmtImg = $pdo->prepare("INSERT INTO `product_images` 
        (`product_id`, `image_url`, `caption`, `is_primary`, `display_order`) 
        VALUES (?, ?, ?, ?, ?)");

    foreach ($products as $p) {
        $stmtProd->execute([
            $p['cat_slug'],
            $p['slug'],
            $p['title'],
            $p['subtitle'],
            $p['badge'],
            $p['short_desc'],
            $p['full_desc'],
            $p['weight'],
            $p['width'],
            $p['yarn'],
            $p['weave'],
            $p['finish'],
            $p['tensile'],
            $p['applications'],
            $p['features'],
            $p['is_featured']
        ]);
        $productId = $pdo->lastInsertId();

        // Seed product images
        $imgOrder = 1;
        foreach ($p['images'] as $img) {
            $stmtImg->execute([
                $productId,
                $img['url'],
                $img['caption'],
                $img['is_primary'],
                $imgOrder++
            ]);
        }
    }
}
