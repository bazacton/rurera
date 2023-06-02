@extends('admin.layouts.app')
@php
$toolbar_tools  = toolbar_tools();
$element_properties_meta    = element_properties_meta($chapters);
$tabs_options    = tabs_options();
$rand_id = rand(999,99999);


@endphp


@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css?ver={{$rand_id}}">
<link rel="stylesheet" href="/assets/default/css/quiz-create.css?ver={{$rand_id}}">
<link href="/assets/default/css/jquery-ui/jquery-ui.min.css" rel="stylesheet">
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<script src="/assets/default/js/admin/jquery.min.js"></script>
<script src="/assets/default/js/admin/question-create.js?ver={{$rand_id}}"></script>
<link rel="stylesheet" href="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.css">
<style>
    .image-field, .image-field-box {
        width: fit-content;
    }
    .image-field img, .containment-wrapper{
            position:relative !important;
        }
    .image-field-box{
                position:absolute !important;
            }
</style>
@endpush

@section('content')

<section class="section form-class" data-question_save_type="update_question">
    <div class="section-header">
        <h1>{{ $pageTitle }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">{{ $pageTitle }}</div>
        </div>

    </div>

    <div class="section-body lms-quiz-create">

        <div class="row">
            <div class="col-12 col-md-12">

                <div class="row">
                    <div class="col-7 col-md-7">
                        <div class="hap-container">
                            <div class="hap-content">
                                <div class="hap-content-area">
                                    <div id="global-message-container">
                                    </div>
                                    <div class="hap-content-box">
                                        <script>leform_gettingstarted_enable = "off";</script>
                                        <div class="wrap leform-admin leform-admin-editor">
                                            <div class="leform-form-editor">
                                                <div class="leform-toolbars">
                                                    <div class="leform-header"></div>
                                                    <div class="leform-pages-bar">
                                                        <ul class="leform-pages-bar-items hide">
                                                            <li class="leform-pages-bar-item" data-id="1"
                                                                data-name="Page"><label
                                                                    onclick="return leform_pages_activate(this);">Page</label><span><a
                                                                        href="#" data-type="page"
                                                                        onclick="return leform_properties_open(this);"><i
                                                                            class="fas fa-cog"></i></a><a href="#"
                                                                                                          class="leform-pages-bar-item-delete leform-pages-bar-item-delete-disabled"
                                                                                                          onclick="return leform_pages_delete(this);"><i
                                                                            class="fas fa-trash-alt"></i></a></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="leform-toolbar">
                                                        <ul class="leform-toolbar-list">
                                                            @php
                                                            foreach ($toolbar_tools as $key => $value) {
                                                            if (array_key_exists('options', $value)) {
                                                            echo '
                                                            <li class="leform-toolbar-tool-' . esc_html($value['type']) . '"
                                                                class="leform-toolbar-list-options"
                                                                data-type="' . esc_html($key) . '" data-option="2"><a
                                                                    href="#"
                                                                    title="' . esc_html($value['title']) . '"><i
                                                                        class="' . esc_html($value['icon']) . '"></i></a>
                                                                <ul class="' . esc_html($key) . '">';
                                                                    foreach ($value['options'] as $option_key =>
                                                                    $option_value) {
                                                                    echo '
                                                                    <li data-type="' . esc_html($key) . '"
                                                                        data-option="' . esc_html($option_key) . '"
                                                                        title=""><a href="#"
                                                                                    title="' . esc_html($value['title']) . '">'
                                                                            . esc_html($option_value) . '</a></li>
                                                                    ';
                                                                    }
                                                                    echo '
                                                                </ul>
                                                            </li>
                                                            ';
                                                            } else {
                                                            echo '
                                                            <li class="leform-toolbar-tool-' . esc_html($value['type']) . '"
                                                                data-type="' . esc_html($key) . '"><a href="#"
                                                                                                      title="' . esc_html($value['title']) . '"><i
                                                                        class="' . esc_html($value['icon']) . '"></i></a>
                                                            </li>
                                                            ';
                                                            }
                                                            }
                                                            @endphp

                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="leform-builder">
                                                    <div class="leform-form-global-style"></div>
                                                    <div id="leform-form-1" class="leform-form leform-elements"
                                                         _data-parent="1" _data-parent-col="0"></div>
                                                </div>
                                            </div>
                                            <iframe data-loading="false" id="leform-import-style-iframe"
                                                    name="leform-import-style-iframe" src="about:blank"
                                                    onload="leform_stylemanager_imported(this);"></iframe>
                                            <form id="leform-import-style-form" enctype="multipart/form-data"
                                                  method="post" target="leform-import-style-iframe"
                                                  action="http://baz.com/greenform/?page=leform&leform-action=import-style">
                                                <input id="leform-import-style-file" type="file" accept=".txt, .zip"
                                                       name="leform-file"
                                                       onchange="jQuery('#leform-import-style-iframe').attr('data-loading', 'true'); jQuery('#leform-import-style-form').submit();">
                                            </form>
                                            <div class="leform-admin-popup-overlay"
                                                 id="leform-element-properties-overlay"></div>
                                            <div class="leform-admin-popup" id="leform-element-properties">
                                                <div class="leform-admin-popup-inner">
                                                    <div class="leform-admin-popup-title">
                                                        <a href="#" title="Close"
                                                           onclick="return leform_properties_close();"><i
                                                                class="fas fa-times"></i></a>
                                                        <h3><i class="fas fa-cog"></i> Element Properties</h3>
                                                    </div>
                                                    <div class="leform-admin-popup-content">
                                                        <div class="leform-admin-popup-content-form">
                                                        </div>
                                                    </div>
                                                    <div class="leform-admin-popup-buttons">
                                                        <a class="leform-admin-button generate-question-code"
                                                           href="#"><i class="fas fa-check"></i><label>Save
                                                                Details</label></a>
                                                    </div>
                                                    <div class="leform-admin-popup-loading"><i
                                                            class="fas fa-spinner fa-spin"></i></div>
                                                </div>
                                            </div>
                                            <div class="leform-fa-selector-overlay"></div>
                                            <div class="leform-fa-selector">
                                                <div class="leform-fa-selector-inner">
                                                    <div class="leform-fa-selector-header">
                                                        <a href="#" title="Close"
                                                           onclick="return leform_fa_selector_close();"><i
                                                                class="fas fa-times"></i></a>
                                                        <input type="text" placeholder="Search...">
                                                    </div>
                                                    <div class="leform-fa-selector-content">
                                                        <span title="No icon" onclick="leform_fa_selector_set(this);"><i
                                                                class=""></i></span><span title="Star"
                                                                                          onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-star"></i></span><span
                                                            title="Star O" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-star-o"></i></span><span
                                                            title="Check" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-check"></i></span><span
                                                            title="Close" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-close"></i></span><span
                                                            title="Lock" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-lock"></i></span><span
                                                            title="Picture O" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-picture-o"></i></span><span
                                                            title="Upload" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-upload"></i></span><span
                                                            title="Download" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-download"></i></span><span
                                                            title="Calendar" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-calendar"></i></span><span
                                                            title="Clock O" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-clock-o"></i></span><span
                                                            title="Chevron Left"
                                                            onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-chevron-left"></i></span><span
                                                            title="Chevron Right"
                                                            onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-chevron-right"></i></span><span
                                                            title="Phone" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-phone"></i></span><span
                                                            title="Envelope" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-envelope"></i></span><span
                                                            title="Envelope O"
                                                            onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-envelope-o"></i></span><span
                                                            title="Pencil" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-pencil"></i></span><span
                                                            title="Angle Double Left"
                                                            onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-angle-double-left"></i></span><span
                                                            title="Angle Double Right"
                                                            onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-angle-double-right"></i></span><span
                                                            title="Spinner" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-spinner"></i></span><span
                                                            title="Smile O" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-smile-o"></i></span><span
                                                            title="Frown O" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-frown-o"></i></span><span
                                                            title="Meh O" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-meh-o"></i></span><span
                                                            title="Send" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-send"></i></span><span
                                                            title="Send O" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-send-o"></i></span><span
                                                            title="User" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-user"></i></span><span
                                                            title="User O" onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-user-o"></i></span><span
                                                            title="Building O"
                                                            onclick="leform_fa_selector_set(this);"><i
                                                                class="leform-fa leform-fa-building-o"></i></span>
                                                    </div>
                                                </div>
                                            </div>


                                            <div id="leform-global-message"></div>
                                            <div class="leform-dialog-overlay" id="leform-dialog-overlay"></div>
                                            <div class="leform-dialog" id="leform-dialog">
                                                <div class="leform-dialog-inner">
                                                    <div class="leform-dialog-title">
                                                        <a href="#" title="Close"
                                                           onclick="return leform_dialog_close();"><i
                                                                class="fas fa-times"></i></a>
                                                        <h3><i class="fas fa-cog"></i><label></label></h3>
                                                    </div>
                                                    <div class="leform-dialog-content">
                                                        <div class="leform-dialog-content-html">
                                                        </div>
                                                    </div>
                                                    <div class="leform-dialog-buttons">
                                                        <a class="leform-dialog-button leform-dialog-button-ok" href="#"
                                                           onclick="return false;"><i
                                                                class="fas fa-check"></i><label></label></a>
                                                        <a class="leform-dialog-button leform-dialog-button-cancel"
                                                           href="#" onclick="return false;"><i class="fas fa-times"></i><label></label></a>
                                                    </div>
                                                    <div class="leform-dialog-loading"><i
                                                            class="fas fa-spinner fa-spin"></i></div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="leform-id" value="3"/>
                                            <script>
                                                var leform_webfonts = ["ABeeZee", "Abel", "Abhaya Libre", "Abril Fatface", "Aclonica", "Acme", "Actor", "Adamina", "Advent Pro", "Aguafina Script", "Akronim", "Aladin", "Alata", "Alatsi", "Aldrich", "Alef", "Alegreya", "Alegreya Sans", "Alegreya Sans SC", "Alegreya SC", "Aleo", "Alex Brush", "Alfa Slab One", "Alice", "Alike", "Alike Angular", "Allan", "Allerta", "Allerta Stencil", "Allura", "Almarai", "Almendra", "Almendra Display", "Almendra SC", "Amarante", "Amaranth", "Amatic SC", "Amethysta", "Amiko", "Amiri", "Amita", "Anaheim", "Andada", "Andika", "Andika New Basic", "Angkor", "Annie Use Your Telescope", "Anonymous Pro", "Antic", "Antic Didone", "Antic Slab", "Anton", "Arapey", "Arbutus", "Arbutus Slab", "Architects Daughter", "Archivo", "Archivo Black", "Archivo Narrow", "Aref Ruqaa", "Arima Madurai", "Arimo", "Arizonia", "Armata", "Arsenal", "Artifika", "Arvo", "Arya", "Asap", "Asap Condensed", "Asar", "Asset", "Assistant", "Astloch", "Asul", "Athiti", "Atma", "Atomic Age", "Aubrey", "Audiowide", "Autour One", "Average", "Average Sans", "Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre", "Averia Serif Libre", "B612", "B612 Mono", "Bad Script", "Bahiana", "Bahianita", "Bai Jamjuree", "Baloo 2", "Baloo Bhai 2", "Baloo Bhaina 2", "Baloo Chettan 2", "Baloo Da 2", "Baloo Paaji 2", "Baloo Tamma 2", "Baloo Tammudu 2", "Baloo Thambi 2", "Balsamiq Sans", "Balthazar", "Bangers", "Barlow", "Barlow Condensed", "Barlow Semi Condensed", "Barriecito", "Barrio", "Basic", "Baskervville", "Battambang", "Baumans", "Bayon", "Be Vietnam", "Bebas Neue", "Belgrano", "Bellefair", "Belleza", "Bellota", "Bellota Text", "BenchNine", "Bentham", "Berkshire Swash", "Beth Ellen", "Bevan", "Big Shoulders Display", "Big Shoulders Inline Display", "Big Shoulders Inline Text", "Big Shoulders Stencil Display", "Big Shoulders Stencil Text", "Big Shoulders Text", "Bigelow Rules", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "BioRhyme", "BioRhyme Expanded", "Biryani", "Bitter", "Black And White Picture", "Black Han Sans", "Black Ops One", "Blinker", "Bodoni Moda", "Bokor", "Bonbon", "Boogaloo", "Bowlby One", "Bowlby One SC", "Brawler", "Bree Serif", "Bubblegum Sans", "Bubbler One", "Buda", "Buenard", "Bungee", "Bungee Hairline", "Bungee Inline", "Bungee Outline", "Bungee Shade", "Butcherman", "Butterfly Kids", "Cabin", "Cabin Condensed", "Cabin Sketch", "Caesar Dressing", "Cagliostro", "Cairo", "Caladea", "Calistoga", "Calligraffitti", "Cambay", "Cambo", "Candal", "Cantarell", "Cantata One", "Cantora One", "Capriola", "Cardo", "Carme", "Carrois Gothic", "Carrois Gothic SC", "Carter One", "Castoro", "Catamaran", "Caudex", "Caveat", "Caveat Brush", "Cedarville Cursive", "Ceviche One", "Chakra Petch", "Changa", "Changa One", "Chango", "Charm", "Charmonman", "Chathura", "Chau Philomene One", "Chela One", "Chelsea Market", "Chenla", "Cherry Cream Soda", "Cherry Swash", "Chewy", "Chicle", "Chilanka", "Chivo", "Chonburi", "Cinzel", "Cinzel Decorative", "Clicker Script", "Coda", "Coda Caption", "Codystar", "Coiny", "Combo", "Comfortaa", "Comic Neue", "Coming Soon", "Commissioner", "Concert One", "Condiment", "Content", "Contrail One", "Convergence", "Cookie", "Copse", "Corben", "Cormorant", "Cormorant Garamond", "Cormorant Infant", "Cormorant SC", "Cormorant Unicase", "Cormorant Upright", "Courgette", "Courier Prime", "Cousine", "Coustard", "Covered By Your Grace", "Crafty Girls", "Creepster", "Crete Round", "Crimson Pro", "Crimson Text", "Croissant One", "Crushed", "Cuprum", "Cute Font", "Cutive", "Cutive Mono", "Damion", "Dancing Script", "Dangrek", "Darker Grotesque", "David Libre", "Dawning of a New Day", "Days One", "Dekko", "Delius", "Delius Swash Caps", "Delius Unicase", "Della Respira", "Denk One", "Devonshire", "Dhurjati", "Didact Gothic", "Diplomata", "Diplomata SC", "DM Mono", "DM Sans", "DM Serif Display", "DM Serif Text", "Do Hyeon", "Dokdo", "Domine", "Donegal One", "Doppio One", "Dorsa", "Dosis", "Dr Sugiyama", "Duru Sans", "Dynalight", "Eagle Lake", "East Sea Dokdo", "Eater", "EB Garamond", "Economica", "Eczar", "El Messiri", "Electrolize", "Elsie", "Elsie Swash Caps", "Emblema One", "Emilys Candy", "Encode Sans", "Encode Sans Condensed", "Encode Sans Expanded", "Encode Sans Semi Condensed", "Encode Sans Semi Expanded", "Engagement", "Englebert", "Enriqueta", "Epilogue", "Erica One", "Esteban", "Euphoria Script", "Ewert", "Exo", "Exo 2", "Expletus Sans", "Fahkwang", "Fanwood Text", "Farro", "Farsan", "Fascinate", "Fascinate Inline", "Faster One", "Fasthand", "Fauna One", "Faustina", "Federant", "Federo", "Felipa", "Fenix", "Finger Paint", "Fira Code", "Fira Mono", "Fira Sans", "Fira Sans Condensed", "Fira Sans Extra Condensed", "Fjalla One", "Fjord One", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky", "Forum", "Francois One", "Frank Ruhl Libre", "Fraunces", "Freckle Face", "Fredericka the Great", "Fredoka One", "Freehand", "Fresca", "Frijole", "Fruktur", "Fugaz One", "Gabriela", "Gaegu", "Gafata", "Galada", "Galdeano", "Galindo", "Gamja Flower", "Gayathri", "Gelasio", "Gentium Basic", "Gentium Book Basic", "Geo", "Geostar", "Geostar Fill", "Germania One", "GFS Didot", "GFS Neohellenic", "Gidugu", "Gilda Display", "Girassol", "Give You Glory", "Glass Antiqua", "Glegoo", "Gloria Hallelujah", "Goblin One", "Gochi Hand", "Goldman", "Gorditas", "Gothic A1", "Gotu", "Goudy Bookletter 1911", "Graduate", "Grand Hotel", "Grandstander", "Gravitas One", "Great Vibes", "Grenze", "Grenze Gotisch", "Griffy", "Gruppo", "Gudea", "Gugi", "Gupter", "Gurajada", "Habibi", "Hachi Maru Pop", "Halant", "Hammersmith One", "Hanalei", "Hanalei Fill", "Handlee", "Hanuman", "Happy Monkey", "Harmattan", "Headland One", "Heebo", "Henny Penny", "Hepta Slab", "Herr Von Muellerhoff", "Hi Melody", "Hind", "Hind Guntur", "Hind Madurai", "Hind Siliguri", "Hind Vadodara", "Holtwood One SC", "Homemade Apple", "Homenaje", "Ibarra Real Nova", "IBM Plex Mono", "IBM Plex Sans", "IBM Plex Sans Condensed", "IBM Plex Serif", "Iceberg", "Iceland", "IM Fell Double Pica", "IM Fell Double Pica SC", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer", "IM Fell Great Primer SC", "Imbue", "Imprima", "Inconsolata", "Inder", "Indie Flower", "Inika", "Inknut Antiqua", "Inria Sans", "Inria Serif", "Inter", "Irish Grover", "Istok Web", "Italiana", "Italianno", "Itim", "Jacques Francois", "Jacques Francois Shadow", "Jaldi", "JetBrains Mono", "Jim Nightshade", "Jockey One", "Jolly Lodger", "Jomhuria", "Jomolhari", "Josefin Sans", "Josefin Slab", "Jost", "Joti One", "Jua", "Judson", "Julee", "Julius Sans One", "Junge", "Jura", "Just Another Hand", "Just Me Again Down Here", "K2D", "Kadwa", "Kalam", "Kameron", "Kanit", "Kantumruy", "Karla", "Karma", "Katibeh", "Kaushan Script", "Kavivanar", "Kavoon", "Kdam Thmor", "Keania One", "Kelly Slab", "Kenia", "Khand", "Khmer", "Khula", "Kirang Haerang", "Kite One", "Knewave", "Kodchasan", "KoHo", "Kosugi", "Kosugi Maru", "Kotta One", "Koulen", "Kranky", "Kreon", "Kristi", "Krona One", "Krub", "Kufam", "Kulim Park", "Kumar One", "Kumar One Outline", "Kumbh Sans", "Kurale", "La Belle Aurore", "Lacquer", "Laila", "Lakki Reddy", "Lalezar", "Lancelot", "Langar", "Lateef", "Lato", "League Script", "Leckerli One", "Ledger", "Lekton", "Lemon", "Lemonada", "Lexend Deca", "Lexend Exa", "Lexend Giga", "Lexend Mega", "Lexend Peta", "Lexend Tera", "Lexend Zetta", "Libre Barcode 128", "Libre Barcode 128 Text", "Libre Barcode 39", "Libre Barcode 39 Extended", "Libre Barcode 39 Extended Text", "Libre Barcode 39 Text", "Libre Barcode EAN13 Text", "Libre Baskerville", "Libre Caslon Display", "Libre Caslon Text", "Libre Franklin", "Life Savers", "Lilita One", "Lily Script One", "Limelight", "Linden Hill", "Literata", "Liu Jian Mao Cao", "Livvic", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow", "Londrina Sketch", "Londrina Solid", "Long Cang", "Lora", "Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel", "Luckiest Guy", "Lusitana", "Lustria", "M PLUS 1p", "M PLUS Rounded 1c", "Ma Shan Zheng", "Macondo", "Macondo Swash Caps", "Mada", "Magra", "Maiden Orange", "Maitree", "Major Mono Display", "Mako", "Mali", "Mallanna", "Mandali", "Manjari", "Manrope", "Mansalva", "Manuale", "Marcellus", "Marcellus SC", "Marck Script", "Margarine", "Markazi Text", "Marko One", "Marmelad", "Martel", "Martel Sans", "Marvel", "Mate", "Mate SC", "Maven Pro", "McLaren", "Meddon", "MedievalSharp", "Medula One", "Meera Inimai", "Megrim", "Meie Script", "Merienda", "Merienda One", "Merriweather", "Merriweather Sans", "Metal", "Metal Mania", "Metamorphous", "Metrophobic", "Michroma", "Milonga", "Miltonian", "Miltonian Tattoo", "Mina", "Miniver", "Miriam Libre", "Mirza", "Miss Fajardose", "Mitr", "Modak", "Modern Antiqua", "Mogra", "Molengo", "Molle", "Monda", "Monofett", "Monoton", "Monsieur La Doulaise", "Montaga", "Montez", "Montserrat", "Montserrat Alternates", "Montserrat Subrayada", "Moul", "Moulpali", "Mountains of Christmas", "Mouse Memoirs", "Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards", "Mukta", "Mukta Mahee", "Mukta Malar", "Mukta Vaani", "Mulish", "MuseoModerno", "Mystery Quest", "Nanum Brush Script", "Nanum Gothic", "Nanum Gothic Coding", "Nanum Myeongjo", "Nanum Pen Script", "Nerko One", "Neucha", "Neuton", "New Rocker", "News Cycle", "Niconne", "Niramit", "Nixie One", "Nobile", "Nokora", "Norican", "Nosifer", "Notable", "Nothing You Could Do", "Noticia Text", "Noto Sans", "Noto Sans HK", "Noto Sans JP", "Noto Sans KR", "Noto Sans SC", "Noto Sans TC", "Noto Serif", "Noto Serif JP", "Noto Serif KR", "Noto Serif SC", "Noto Serif TC", "Nova Cut", "Nova Flat", "Nova Mono", "Nova Oval", "Nova Round", "Nova Script", "Nova Slim", "Nova Square", "NTR", "Numans", "Nunito", "Nunito Sans", "Odibee Sans", "Odor Mean Chey", "Offside", "Old Standard TT", "Oldenburg", "Oleo Script", "Oleo Script Swash Caps", "Open Sans", "Open Sans Condensed", "Oranienbaum", "Orbitron", "Oregano", "Orienta", "Original Surfer", "Oswald", "Over the Rainbow", "Overlock", "Overlock SC", "Overpass", "Overpass Mono", "Ovo", "Oxanium", "Oxygen", "Oxygen Mono", "Pacifico", "Padauk", "Palanquin", "Palanquin Dark", "Pangolin", "Paprika", "Parisienne", "Passero One", "Passion One", "Pathway Gothic One", "Patrick Hand", "Patrick Hand SC", "Pattaya", "Patua One", "Pavanam", "Paytone One", "Peddana", "Peralta", "Permanent Marker", "Petit Formal Script", "Petrona", "Philosopher", "Piazzolla", "Piedra", "Pinyon Script", "Pirata One", "Plaster", "Play", "Playball", "Playfair Display", "Playfair Display SC", "Podkova", "Poiret One", "Poller One", "Poly", "Pompiere", "Pontano Sans", "Poor Story", "Poppins", "Port Lligat Sans", "Port Lligat Slab", "Potta One", "Pragati Narrow", "Prata", "Preahvihear", "Press Start 2P", "Pridi", "Princess Sofia", "Prociono", "Prompt", "Prosto One", "Proza Libre", "PT Mono", "PT Sans", "PT Sans Caption", "PT Sans Narrow", "PT Serif", "PT Serif Caption", "Public Sans", "Puritan", "Purple Purse", "Quando", "Quantico", "Quattrocento", "Quattrocento Sans", "Questrial", "Quicksand", "Quintessential", "Qwigley", "Racing Sans One", "Radley", "Rajdhani", "Rakkas", "Raleway", "Raleway Dots", "Ramabhadra", "Ramaraja", "Rambla", "Rammetto One", "Ranchers", "Rancho", "Ranga", "Rasa", "Rationale", "Ravi Prakash", "Recursive", "Red Hat Display", "Red Hat Text", "Red Rose", "Redressed", "Reem Kufi", "Reenie Beanie", "Revalia", "Rhodium Libre", "Ribeye", "Ribeye Marrow", "Righteous", "Risque", "Roboto", "Roboto Condensed", "Roboto Mono", "Roboto Slab", "Rochester", "Rock Salt", "Rokkitt", "Romanesco", "Ropa Sans", "Rosario", "Rosarivo", "Rouge Script", "Rowdies", "Rozha One", "Rubik", "Rubik Mono One", "Ruda", "Rufina", "Ruge Boogie", "Ruluko", "Rum Raisin", "Ruslan Display", "Russo One", "Ruthie", "Rye", "Sacramento", "Sahitya", "Sail", "Saira", "Saira Condensed", "Saira Extra Condensed", "Saira Semi Condensed", "Saira Stencil One", "Salsa", "Sanchez", "Sancreek", "Sansita", "Sansita Swashed", "Sarabun", "Sarala", "Sarina", "Sarpanch", "Satisfy", "Sawarabi Gothic", "Sawarabi Mincho", "Scada", "Scheherazade", "Schoolbell", "Scope One", "Seaweed Script", "Secular One", "Sedgwick Ave", "Sedgwick Ave Display", "Sen", "Sevillana", "Seymour One", "Shadows Into Light", "Shadows Into Light Two", "Shanti", "Share", "Share Tech", "Share Tech Mono", "Shojumaru", "Short Stack", "Shrikhand", "Siemreap", "Sigmar One", "Signika", "Signika Negative", "Simonetta", "Single Day", "Sintony", "Sirin Stencil", "Six Caps", "Skranji", "Slabo 13px", "Slabo 27px", "Slackey", "Smokum", "Smythe", "Sniglet", "Snippet", "Snowburst One", "Sofadi One", "Sofia", "Solway", "Song Myung", "Sonsie One", "Sora", "Sorts Mill Goudy", "Source Code Pro", "Source Sans Pro", "Source Serif Pro", "Space Grotesk", "Space Mono", "Spartan", "Special Elite", "Spectral", "Spectral SC", "Spicy Rice", "Spinnaker", "Spirax", "Squada One", "Sree Krushnadevaraya", "Sriracha", "Srisakdi", "Staatliches", "Stalemate", "Stalinist One", "Stardos Stencil", "Stint Ultra Condensed", "Stint Ultra Expanded", "Stoke", "Strait", "Stylish", "Sue Ellen Francisco", "Suez One", "Sulphur Point", "Sumana", "Sunflower", "Sunshiney", "Supermercado One", "Sura", "Suranna", "Suravaram", "Suwannaphum", "Swanky and Moo Moo", "Syncopate", "Syne", "Syne Mono", "Syne Tactile", "Tajawal", "Tangerine", "Taprom", "Tauri", "Taviraj", "Teko", "Telex", "Tenali Ramakrishna", "Tenor Sans", "Text Me One", "Texturina", "Thasadith", "The Girl Next Door", "Tienne", "Tillana", "Timmana", "Tinos", "Titan One", "Titillium Web", "Tomorrow", "Trade Winds", "Trirong", "Trispace", "Trocchi", "Trochut", "Trykker", "Tulpen One", "Turret Road", "Ubuntu", "Ubuntu Condensed", "Ubuntu Mono", "Ultra", "Uncial Antiqua", "Underdog", "Unica One", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "Unna", "Vampiro One", "Varela", "Varela Round", "Varta", "Vast Shadow", "Vesper Libre", "Viaoda Libre", "Vibes", "Vibur", "Vidaloka", "Viga", "Voces", "Volkhov", "Vollkorn", "Vollkorn SC", "Voltaire", "VT323", "Waiting for the Sunrise", "Wallpoet", "Walter Turncoat", "Warnes", "Wellfleet", "Wendy One", "Wire One", "Work Sans", "Xanh Mono", "Yanone Kaffeesatz", "Yantramanav", "Yatra One", "Yellowtail", "Yeon Sung", "Yeseva One", "Yesteryear", "Yrsa", "Yusei Magic", "ZCOOL KuaiLe", "ZCOOL QingKe HuangYou", "ZCOOL XiaoWei", "Zeyada", "Zhi Mang Xing", "Zilla Slab", "Zilla Slab Highlight"];
                                                var leform_localfonts = ["Arial", "Bookman", "Century Gothic", "Comic Sans MS", "Courier", "Garamond", "Georgia", "Helvetica", "Lucida Grande", "Palatino", "Tahoma", "Times", "Trebuchet MS", "Verdana"];
                                                var leform_customfonts = [];
                                                @php
                                                echo
                                                'var leform_toolbar_tools = '.json_encode($toolbar_tools);
                                                @endphp;
                                                @php
                                                echo
                                                'var leform_meta = '.json_encode($element_properties_meta);
                                                @endphp;
                                                var leform_validators = [];
                                                var leform_filters = [];
                                                var leform_confirmations = [];
                                                var leform_notifications = [];
                                                var leform_integrations = [];
                                                var leform_payment_gateway = [];
                                                var leform_math_expressions_meta = [];
                                                var leform_logic_rules = [];
                                                var leform_predefined_options = [];
                                                @php
                                                echo
                                                'var leform_form_options = '.$tabs_options;
                                                @endphp;
                                                var leform_form_pages_raw = [{
                                                    "general": "general",
                                                    "name": "Page",
                                                    "id": 1,
                                                    "type": "page"
                                                }];
                                                //var leform_form_elements_raw = []; //Default Value for Questions
                                                @php
                                                echo
                                                'var leform_form_elements_raw = '.json_encode($layout_elements);
                                                @endphp;
                                                //var leform_form_elements_raw = ["{\"type\":\"image_quiz\",\"resize\":\"both\",\"height\":\"auto\",\"_parent\":\"1\",\"_parent-col\":\"0\",\"_seq\":0,\"id\":2,\"basic\":\"basic\",\"content\":\"    test     \",\"elements_data\":\"W3siMjM3OCI6eyJmaWVsZF90eXBlIjoiaW1hZ2UiLCJpbWFnZSI6Ii9zdG9yZS8xL2Rhc2hib2FyZC5wbmcifSwiNDAwNjEiOnsiZmllbGRfdHlwZSI6ImltYWdlIiwiaW1hZ2UiOiIvc3RvcmUvMS9kYXNoYm9hcmQucG5nIn19XQ==\"}"];
                                                //var leform_form_elements_raw = ["{\"basic\":\"basic\",\"content\":\&lt;span class=&quot;block-holder&quot;&gt;&lt;img data-field_type=&quot;image&quot; data-id=&quot;2378&quot; id=&quot;field-2378&quot; class=&quot;editor-field&quot; src=&quot;\/store\/1\/dashboard.png&quot; heigh=&quot;50&quot; width=&quot;50&quot; data-image=&quot;\/store\/1\/dashboard.png&quot;&gt;&lt;\/span&gt;&amp;nbsp; &amp;nbsp; test&amp;nbsp; &amp;nbsp;&amp;nbsp;&lt;span class=&quot;block-holder&quot;&gt;&lt;img data-field_type=&quot;image&quot; data-id=&quot;40061&quot; id=&quot;field-40061&quot; class=&quot;editor-field&quot; src=&quot;\/store\/1\/default_images\/admin_dashboard.jpg&quot; heigh=&quot;50&quot; width=&quot;50&quot; data-image=&quot;\/store\/1\/default_images\/admin_dashboard.jpg&quot;&gt;&lt;\/span&gt;&amp;nbsp;&lt;br&gt;",\"elements_data\":{\"2378\":{\"data-field_type\":\"image\",\"data-id\":\"2378\",\"id\":\"field-2378\",\"class\":\"editor-field\",\"src\":\"\/store\/1\/dashboard.png\",\"heigh\":\"50\",\"width\":\"50\",\"data-image\":\"\/store\/1\/dashboard.png\"},\"40061\":{\"data-field_type\":\"image\",\"data-id\":\"40061\",\"id\":\"field-40061\",\"class\":\"editor-field\",\"src\":\"\/store\/1\/default_images\/admin_dashboard.jpg\",\"heigh\":\"50\",\"width\":\"50\",\"data-image\":\"\/store\/1\/default_images\/admin_dashboard.jpg\"}},\"type\":\"image_quiz\",\"resize\":\"both\",\"height\":\"auto\",\"_parent\":\"1\",\"_parent-col\":\"0\",\"_seq\":0,\"id\":2}"];
                                                var leform_integration_providers = [];
                                                var leform_payment_providers = [];
                                                var leform_styles = [{
                                                    "id": "native-35",
                                                    "name": "Beige Beige",
                                                    "type": 1
                                                }, {
                                                    "id": "native-31",
                                                    "name": "Black and White",
                                                    "type": 1
                                                }, {
                                                    "id": "native-30",
                                                    "name": "Blue Lagoon",
                                                    "type": 1
                                                }, {
                                                    "id": "native-45",
                                                    "name": "Chamomile Tea",
                                                    "type": 1
                                                }, {
                                                    "id": "native-32",
                                                    "name": "Classic Green",
                                                    "type": 1
                                                }, {
                                                    "id": "native-34",
                                                    "name": "Dark Night",
                                                    "type": 1
                                                }, {
                                                    "id": "native-29",
                                                    "name": "Deep Space",
                                                    "type": 1
                                                }, {
                                                    "id": "native-27",
                                                    "name": "Default Style",
                                                    "type": 1
                                                }, {
                                                    "id": "native-42",
                                                    "name": "Greenery",
                                                    "type": 1
                                                }, {
                                                    "id": "native-43",
                                                    "name": "Honey Bee",
                                                    "type": 1
                                                }, {
                                                    "id": "native-44",
                                                    "name": "Honeysuckle",
                                                    "type": 1
                                                }, {
                                                    "id": "native-47",
                                                    "name": "Lava Rocks",
                                                    "type": 1
                                                }, {
                                                    "id": "native-33",
                                                    "name": "Light Blue",
                                                    "type": 1
                                                }, {
                                                    "id": "native-40",
                                                    "name": "Living Coral",
                                                    "type": 1
                                                }, {
                                                    "id": "native-36",
                                                    "name": "Mariana Trench",
                                                    "type": 1
                                                }, {
                                                    "id": "native-37",
                                                    "name": "Peach Button",
                                                    "type": 1
                                                }, {
                                                    "id": "native-46",
                                                    "name": "Something Blue",
                                                    "type": 1
                                                }, {"id": "native-41", "name": "Ultra Violet", "type": 1}];
                                                jQuery(document).ready(function () {
                                                    leform_form_ready();
                                                });
                                                console.log(leform_form_elements_raw);
                                            </script>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-5 col-md-5">
                        <div class="row">

                            <div class="col-12">
                                <div class="lms-dashboard-card">
                                    <div class="lms-card-body">
                                        <div class="lms-card-title">
                                            <h4 style="text-transform: capitalize;">Activity</h4>
                                        </div>
                                        <ul class="lms-card-timeline">

                                            @if( !empty( $questionLogs ))
                                            @foreach($questionLogs as $logObj)


                                            <li class="lms-card-list">
                                                <div class="lms-card-icons"><i data-feather="arrow-right-circle" width="20"
                                                                               height="20"
                                                                               class=""></i></div>
                                                <div class="lms-card-info">
                                                    <h5>{{$logObj->user->full_name}} @ <b>{{ dateTimeFormat
                                                            ($logObj->action_at, 'j M y | H:i')
                                                            }} <span><i data-feather="arrow-right" width="20" height="20"
                                                                        class=""></i></span>
                                                    </h5>
                                                    <p>{{$logObj->action_type}}</p>
                                                    <p>{!! $logObj->log_data !!}</p>
                                                    @if($logObj->action_type == 'Status Updated - Published' &&
                                                    $logObj->action_role ==
                                                    'reviewer')
                                                    @php
                                                    $log_storred_data = json_decode($logObj->log_storred_data);
                                                    $log_storred_data = (array) $log_storred_data;
                                                    if(!empty($log_storred_data)){
                                                    $log_storred_data['Solution'] = $log_storred_data['Solution'].'
                                                    ('.$log_storred_data['Solution Label'].')';
                                                    $log_storred_data['Difficulty Level'] = $log_storred_data['Difficulty
                                                    Level'].'
                                                    ('.$log_storred_data['Difficulty Level Label'].')';
                                                    unset($log_storred_data['Solution Label']);
                                                    unset($log_storred_data['Difficulty Level Label']);
                                                    unset($log_storred_data['status_details']);
                                                    $log_storred_data['Accepted'] = 20;
                                                    }

                                                    @endphp
                                                    @if( !empty( $log_storred_data ))
                                                    @foreach( $log_storred_data as $storred_dataObj_key =>
                                                    $storred_dataObj_value)
                                                    <span>{{$storred_dataObj_key}}: {{$storred_dataObj_value}}</span><br>
                                                    @endforeach
                                                    @endif

                                                    @endif
                                                </div>
                                            </li>

                                            @endforeach
                                            @endif
                                        </ul>
                                        <div class="text-center mt-4"><a class="lms-card-btn" href="#">View More <i
                                                    data-feather="arrow-right"
                                                    width="20" height="20" class=""></i></a></div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label class="input-label">Question Title</label>
                                    <input type="text" value="{{ $question_title }}" name="question_title"
                                           class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="input-label">{{trans('admin/main.category')}}</label>
                                    <select name="category_id" data-plugin-selectTwo
                                            class="form-control populate ajax-category-courses">
                                        <option value="">{{trans('admin/main.all_categories')}}</option>
                                        @foreach($categories as $category)
                                        @if(!empty($category->subCategories) and count($category->subCategories))
                                        <optgroup label="{{  $category->title }}">
                                            @foreach($category->subCategories as $subCategory)
                                            <option value="{{ $subCategory->id }}" @if(request()->get('category_id') ==
                                                $subCategory->id) selected="selected" @endif>{{ $subCategory->title }}
                                            </option>
                                            @endforeach
                                        </optgroup>
                                        @else
                                        <option value="{{ $category->id }}" @if(request()->get('category_id') ==
                                            $category->id)
                                            selected="selected" @endif>{{ $category->title }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="input-label">Course</label>
                                    <select name="course_id" data-plugin-selectTwo
                                            class="form-control populate ajax-courses-dropdown">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="input-label">Chapter</label>
                                    <select id="chapter_id" class="form-control populate ajax-chapter-dropdown"
                                            name="chapter_id">
                                    </select>

                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="input-label">Search Keywords / Tags</label>
                                    @php
                                    $search_tags = explode(' | ', $questionObj->search_tags);
                                    $search_tags = implode(',', $search_tags);
                                    @endphp
                                    <input type="text" value="{{ $search_tags }}" data-role="tagsinput"
                                           name="search_tags"
                                           class="form-control @error('search_tags')  is-invalid @enderror"
                                           placeholder=""/>
                                    @error('search_tags')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="input-label">Score</label>
                                    <input type="text" value="{{ $question_score }}" name="question_score"
                                           class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="input-label">Average Time</label>
                                    <input type="text" value="{{ $question_average_time }}" name="question_average_time"
                                           class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="input-label">Difficulty Level</label>
                                    <select name="difficulty_level" class="custom-select ">
                                        <option value="Below" {{ ($question_difficulty_level==
                                        'Below') ? 'selected' : '' }}>Below</option>
                                        <option value="Emerging" {{ ($question_difficulty_level==
                                        'Emerging') ? 'selected' : '' }}>Emerging</option>
                                        <option value="Expected" {{ ($question_difficulty_level==
                                        'Expected') ? 'selected' : '' }}>Expected</option>
                                        <option value="Exceeding" {{ ($question_difficulty_level==
                                        'Exceeding') ? 'selected' : '' }}>Exceeding</option>
                                        <option value="Challenge" {{ ($question_difficulty_level==
                                        'Challenge') ? 'selected' : '' }}>Challenge</option>
                                    </select>
                                </div>
                            </div>
                            @if(auth()->user()->isReviewer())
                            @if($questionObj->question_status == 'Submit for review' || $questionObj->question_status ==
                            'On hold')
                            <div class="col-12">
                                <button type="button" data-question_id="{{$questionObj->id}}"
                                        class="question-action-btn btn btn-warning">Action
                                </button>
                            </div>
                            @endif
                            @endif

                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label class="input-label">Glossary</label>
                            <select name="glossary_ids[]" id="glossary_ids" class="glossary-items form-control"
                                    multiple>
                                @if(!empty($glossary))
                                @foreach($glossary as $glossaryData)
                                @php $selected = '' @endphp
                                @if(in_array($glossaryData->id, $glossary_ids))
                                @php $selected = 'selected' @endphp
                                @endif
                                <option value="{{ $glossaryData->id }}" {{$selected}}>{{ $glossaryData->title }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            <a href="javascript:;" class="add-glossary-modal">Add New Glossary</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label class="input-label">Solution</label>
                            <textarea class="note-codable summernote" id="question_solve" name="question_solve"
                                      aria-multiline="true">{{$question_solve}}</textarea>
                        </div>
                    </div>
                    @if(auth()->user()->isAuthor())
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label class="input-label">Comments for Reviewer</label><br>
                            <textarea class="note-codable form-group" cols="100" rows="5"
                                      id="comments_for_reviewer"
                                      name="comments_for_reviewer" aria-multiline="true"></textarea>
                        </div>
                    </div>
                    @endif
                </div>


                <div class="fields-layout-options">


                    <div class='text232-field-options'>
                        <div class='quiz-form-control'>
                            <input type='text' class="element-field" data-field_type="score" value="0" placeholder="Score" data-field_id="field_dynamic_id">
                        </div>
                        <div class='quiz-form-control'>
                            <input type='text' class="element-field" data-field_type="placeholder" placeholder="Placeholder" data-field_id="field_dynamic_id">
                        </div>
                        <div class='quiz-form-control'>
                            <input type='text' class="element-field" data-field_type="size" value="1" placeholder="Size" data-field_id="field_dynamic_id">
                        </div>
                        <div class='quiz-form-control'>
                            <select class="element-field" data-field_type="field_size" data-field_id="field_dynamic_id">
                                <option value="extra-small">Extra Small</option>
                                <option value="small" selected="selected">Small</option>
                                <option value="medium">Medium</option>
                                <option value="large">Large</option>
                            </select>
                        </div>
                        <i class="fas fa-plus repeater-class" data-field_id="field_dynamic_id"
                           data-field_type="text"></i>
                        <label>Correct Answere</label>
                        <div class="repeater-fields">
                            <div class='quiz-form-control'><input type='text' class="element-field"
                                                                  data-field_type="correct_answere"
                                                                  placeholder="Correct Answere"
                                                                  data-field_id="field_dynamic_id"><i
                                    class="fas fa-trash-alt remove-repeater-field"></i></div>
                        </div>
                    </div>


                    <div class='text-field-options'>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="score"
                                                              value="0" placeholder="Score"
                                                              data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><input type='text' class="element-field"
                                                              data-field_type="placeholder" placeholder="Placeholder"
                                                              data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="size"
                                                              value="1" placeholder="Size"
                                                              data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'>
                            <select class="element-field" data-field_type="field_size" data-field_id="field_dynamic_id">
                                <option value="extra-small">Extra Small</option>
                                <option value="small" selected="selected">Small</option>
                                <option value="medium">Medium</option>
                                <option value="large">Large</option>
                            </select>
                        </div>

                        <div class='quiz-form-control'>
                            <select class="element-field" data-field_type="type" data-field_id="field_dynamic_id">
                                <option value="text" selected="selected">Alpha numeric</option>
                                <option value="number">Numbers</option>
                            </select>
                        </div>
                        <div class='quiz-form-control'><input type='text' class="element-field"
                                                              data-field_type="correct_answere"
                                                              placeholder="Correct Answer"
                                                              data-field_id="field_dynamic_id"></div>
                    </div>



                    <div class='insert_into_sentense-field-options'>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="score"
                                                              value="0" placeholder="Score"
                                                              data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><input type='text' class="element-field"
                                                              data-field_type="correct_answere"
                                                              placeholder="Correct Answer"
                                                              data-field_id="field_dynamic_id"></div>
                    </div>

                    <div class='select-field-options'>
                        <div class='quiz-form-control'>
                            <input type='text' class="element-field" data-field_type="score" placeholder="Score" data-field_id="field_dynamic_id">
                        </div>
                        <div class='quiz-form-control'>
                            <select class="element-field" data-field_type="field_size" data-field_id="field_dynamic_id">
                                <option value="extra-small">Extra Small</option>
                                <option value="small" selected="selected">Small</option>
                                <option value="medium">Medium</option>
                                <option value="large">Large</option>
                                <option value="extra-large">Extra Large</option>

                            </select>
                        </div>
                        <i class="fas fa-plus repeater-class" data-field_id="field_dynamic_id"
                           data-field_type="select"></i>
                        <label>Options</label>
                        <div class="repeater-fields">
                            <div class='quiz-form-control'>
                                <input type='radio' class="select-correct-element-field"
                                       id="correct-field_dynamic_id-option_dynamic_id" name="correct-field_dynamic_id"
                                       data-field_type="option_correct" placeholder="Correct Answere"
                                       data-field_id="field_dynamic_id">
                                <input type='text' class="element-field" data-field_type="select_option"
                                       placeholder="Select Option" data-field_id="field_dynamic_id"
                                       data-field_option_id="correct-field_dynamic_id-option_dynamic_id"><i
                                    class="fas fa-trash-alt remove-repeater-field"></i></div>
                        </div>
                    </div>


                    <div class='radio-field-options'>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="score"
                                                              placeholder="Score" data-field_id="field_dynamic_id">
                        </div>
                        <i class="fas fa-plus repeater-class" data-field_id="field_dynamic_id"
                           data-field_type="radio"></i>
                        <label>Options</label>
                        <div class="repeater-fields">
                            <div class='quiz-form-control'>
                                <input type='radio' class="select-correct-element-field"
                                       id="correct-field_dynamic_id-option_dynamic_id" name="correct-field_dynamic_id"
                                       data-field_type="radio_correct" placeholder="Correct Answere"
                                       data-field_id="field_dynamic_id">
                                <input type='text' class="element-field" data-field_type="radio_option"
                                       placeholder="Select Option" data-field_id="field_dynamic_id"
                                       data-field_option_id="correct-field_dynamic_id-option_dynamic_id"><i
                                    class="fas fa-trash-alt remove-repeater-field"></i></div>
                        </div>
                    </div>

                    <div class='checkbox-field-options'>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="score"
                                                              placeholder="Score" data-field_id="field_dynamic_id">
                        </div>
                        <i class="fas fa-plus repeater-class" data-field_id="field_dynamic_id"
                           data-field_type="checkbox"></i>
                        <label>Options</label>
                        <div class="repeater-fields">
                            <div class='quiz-form-control'>
                                <input type='checkbox' class="select-correct-element-field"
                                       id="correct-field_dynamic_id-option_dynamic_id" name="correct-field_dynamic_id"
                                       data-field_type="checkbox_correct" placeholder="Correct Answere"
                                       data-field_id="field_dynamic_id">
                                <input type='text' class="element-field" data-field_type="checkbox_option"
                                       placeholder="Select Option" data-field_id="field_dynamic_id"
                                       data-field_option_id="correct-field_dynamic_id-option_dynamic_id"><i
                                    class="fas fa-trash-alt remove-repeater-field"></i></div>
                        </div>
                    </div>


                    <div class='paragraph-field-options'>
                        <div class='quiz-form-control'>
                            <select class="element-field" data-field_type="font_heading"
                                    data-field_id="field_dynamic_id">
                                <option value="" selected="selected">Heading</option>
                                <option value="h1">H1</option>
                                <option value="h2">H2</option>
                                <option value="h3">H3</option>
                                <option value="h4">H4</option>
                                <option value="h5">H5</option>
                                <option value="h6">H6</option>
                            </select>
                        </div>
                        <div class='quiz-form-control'><input type='text' class="element-field"
                                                              data-field_type="font_size" placeholder="Font Size"
                                                              data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><input type='text' class="element-field"
                                                              data-field_type="font_color" placeholder="Color"
                                                              data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="link"
                                                              placeholder="Link" data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><select class="element-field" data-field_type="font_align"
                                                               data-field_id="field_dynamic_id">
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                                <option value="right">Right</option>
                            </select>
                        </div>

                        <div class='quiz-form-control'>
                            Bold <input type="checkbox" data-value="bold" class="element-field"
                                        data-field_type="font_styles" data-field_id="field_dynamic_id">&nbsp;&nbsp;&nbsp;
                            Italic <input type="checkbox" data-value="italic" class="element-field"
                                          data-field_type="font_styles" data-field_id="field_dynamic_id">&nbsp;&nbsp;&nbsp;
                            Underline <input type="checkbox" data-value="underline" class="element-field"
                                             data-field_type="font_styles" data-field_id="field_dynamic_id">&nbsp;&nbsp;&nbsp;
                            Line through<input type="checkbox" data-value="line-through" class="element-field"
                                               data-field_type="font_styles" data-field_id="field_dynamic_id">
                        </div>
                    </div>


                    <div class='image-field-options'>


                        <div class="quiz-form-control form-group mt-15">
                            <label class="input-label">Image</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="input-group-text admin-file-manager"
                                            data-input="image_field_dynamic_id" data-preview="holder">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </div>
                                <input type="text" name="image_cover" id="image_field_dynamic_id" value=""
                                       data-field_type="image" data-field_id="field_dynamic_id"
                                       class="element-field form-control"/>
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text admin-file-view"
                                            data-input="image_field_dynamic_id">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="height"
                                                              placeholder="Height" data-field_id="field_dynamic_id">
                        </div>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="width"
                                                              placeholder="Width" data-field_id="field_dynamic_id">
                        </div>
                    </div>

                </div>


                <div class="mt-5 mb-5 create-question-fields-block">
                    @if(auth()->user()->isAuthor() || auth()->user()->isAdmin())
                    <button type="button" data-status="Draft" class="quiz-stage-generate btn btn-warning">Draft</button>
                    <button type="button" data-status="Submit for review" class="quiz-stage-generate btn btn-primary">
                        Submit for review
                    </button>
                    @endif

                    @if(auth()->user()->isReviewer())
                    <button type="button" data-status="{{$questionObj->question_status}}"
                            class="quiz-stage-generate btn btn-warning">Update
                    </button>
                    @endif

                    <button type="submit" class="submit-btn-quiz-create btn btn-primary hide">{{ !empty($quiz) ?
                        trans('admin/main.save_change') : trans('admin/main.create') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>


<div id="add-glosary-modal-box" class="question_glossary_modal modal fade question_status_action_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form name="question_status_action_form" id="question_status_action_form">
                    <div class="form-group">
                        <label>{{ trans('/admin/main.category') }}</label>
                        <select class="form-control @error('category_id') is-invalid @enderror"
                                name="ajax[category_id]">
                            <option {{ !empty($trend) ?
                            '' : 'selected' }} disabled>{{ trans('admin/main.choose_category') }}</option>

                            @foreach($categories as $category)
                            @if(!empty($category->subCategories) and count($category->subCategories))
                            <optgroup label="{{  $category->title }}">
                                @foreach($category->subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}">{{ $subCategory->title }}</option>
                                @endforeach
                            </optgroup>
                            @endif
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>Glossary Title</label>
                        <input type="text" name="ajax[title]" class="form-control  @error('title') is-invalid @enderror"
                               placeholder="{{ trans('admin/main.choose_title') }}"/>
                        @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="input-label">Description</label>
                        <textarea class="note-codable summernote" id="description" name="ajax[description]"
                                  aria-multiline="true"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-right">
                    <a href="javascript:;" class="btn btn-primary question_glossary_submit_btn">Submit</a>
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div id="question_status_action_modal" class="modal fade question_status_action_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Question Actions</h3>
            </div>
            <div class="modal-body">
                <form name="question_status_action_form" id="question_status_action_form">
                    <div class="row">

                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <select name="question_status" class="question_status_update custom-select">
                                    <option value="">Action</option>
                                    <option value="Accepted" selected="selected">Accepted</option>
                                    <option value="On hold">On hold</option>
                                    <option value="Improvement required">Improvement required</option>
                                    <option value="Hard reject">Hard reject</option>
                                </select>
                            </div>
                        </div>

                        <div class="question-status-fields" data-status_label="Accepted">
                            <div class="col-12 col-md-12">
                                <div class="form-group custom-switches-stacked mt-2">
                                    <label class="custom-switch pl-0">
                                        <input type="checkbox" name="image_question" id="image_question" value="1"
                                               class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer"
                                               for="image_question">Image Question</label>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group custom-switches-stacked mt-2">
                                    <label class="custom-switch pl-0">
                                        <input type="checkbox" name="word_problem" id="word_problem" value="1"
                                               class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer" for="word_problem">Word
                                            Problem</label>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group custom-switches-stacked mt-2">
                                    <label class="custom-switch pl-0">
                                        <input type="checkbox" name="new_glossary" id="new_glossary" value="1"
                                               class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer" for="new_glossary">New
                                            Glossary</label>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-12 glossary_illustration_field hide">
                                <div class="form-group custom-switches-stacked mt-2">
                                    <label class="custom-switch pl-0">
                                        <input type="checkbox" name="glossary_with_illustration"
                                               id="glossary_with_illustration" value="1" class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer"
                                               for="glossary_with_illustration">Glossary with Illustration</label>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">

                                <label class="input-label">Solution</label>
                                <input type="radio" class="btn-check" name="solution" id="Acceptable" value="Acceptable"
                                       autocomplete="off" checked="checked">
                                <label class="btn btn-secondary" for="Acceptable">Acceptable</label>

                                <input type="radio" class="btn-check" name="solution" id="Appropriate"
                                       value="Appropriate" autocomplete="off">
                                <label class="btn btn-secondary" for="Appropriate">Appropriate</label>

                                <input type="radio" class="btn-check" name="solution" id="Aspirational"
                                       value="Aspirational" autocomplete="off">
                                <label class="btn btn-secondary" for="Aspirational">Aspirational</label>
                            </div>

                            <div class="col-12 col-md-12">
                                <label class="input-label">Difficulty Level</label>
                                <input type="radio" class="btn-check" name="difficulty_level" id="Standard"
                                       value="Standard" autocomplete="off" checked="checked">
                                <label class="btn btn-secondary" for="Standard">Standard</label>

                                <input type="radio" class="btn-check" name="difficulty_level" id="Medium" value="Medium"
                                       autocomplete="off">
                                <label class="btn btn-secondary" for="Medium">Medium</label>

                                <input type="radio" class="btn-check" name="difficulty_level" id="Expert" value="Expert"
                                       autocomplete="off">
                                <label class="btn btn-secondary" for="Expert">Expert</label>
                            </div>


                            <div class="col-12 col-md-12">
                                <div class="form-group custom-switches-stacked mt-2">
                                    <label class="custom-switch pl-0">
                                        <input type="checkbox" name="publish_question" id="publish_question" value="1"
                                               class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer"
                                               for="publish_question">Publish</label>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label class="input-label">Details</label>
                                <textarea class="note-codable summernote" id="status_details" name="status_details"
                                          aria-multiline="true"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="question_id" value="{{$questionObj->id}}">
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-right">
                    <a href="javascript:;" class="btn btn-primary question_status_submit_btn">Submit</a>
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
<script src="/assets/vendors/summernote/summernote-table-headers.js"></script>
<script src="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script>
    $(document).ready(function () {

        $('.glossary-items').select2();
    });
    var saveSuccessLang = '';</script>


<script src="/assets/default/js/admin/quiz.min.js"></script>
<script type="text/javascript">
    $("body").on("click", ".add-glossary-modal", function (t) {
        $("#add-glosary-modal-box").modal({backdrop: "static"});
    });

    $("body").on("click", ".question-action-btn", function (t) {
        $("#question_status_action_modal").modal({backdrop: "static"});
    });


    $("body").on("change", ".question_status_update", function (t) {
        var question_status = $(this).val();
        $('.question-status-fields').addClass('hide');
        $('.question-status-fields[data-status_label="' + question_status + '"]').removeClass('hide');
    });


    $("body").on("change", "#new_glossary", function (t) {
        if ($(this).is(':checked')) {
            $(".glossary_illustration_field").removeClass('hide');
        } else {
            $(".glossary_illustration_field").addClass('hide');
        }
    });

    $(document).on('change', '.ajax-category-courses', function () {
        var category_id = $(this).val();
        $.ajax({
            type: "GET",
            url: '/admin/webinars/courses_by_categories',
            data: {'category_id': category_id},
            success: function (return_data) {
                $(".ajax-courses-dropdown").html(return_data);
                $(".ajax-chapter-dropdown").html('');
            }
        });
    });

    $(document).on('change', '.ajax-courses-dropdown', function () {
        var course_id = $(this).val();
        $.ajax({
            type: "GET",
            url: '/admin/webinars/chapters_by_course',
            data: {'course_id': course_id},
            success: function (return_data) {
                $(".ajax-chapter-dropdown").html(return_data);
            }
        });
    });


</script>

@endpush
