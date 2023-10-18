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

    .image-field img, .containment-wrapper {
        position: relative !important;
    }

    .image-field-box {
        position: absolute !important;
    }

    /*.draggable3 {
        width: 150px;
    }*/

    .spreadsheet-area {
        border: 1px solid #efefef;
        padding: 10px;
        background: #fff;
        height: 200px;
    }
    .question-layout-data .leform-element{
        outline: none !important;
    }

</style>
@endpush

@section('content')

<section class="section form-class" data-question_save_type="store_question">
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


                <div class="card">
                    <div class="card-body">

                        <ul class="nav nav-pills" id="myTab3" role="tablist">


                            <li class="nav-item">
                                <a class="nav-link active" id="question_properties-tab" data-toggle="tab"
                                   href="#question_properties" role="tab"
                                   aria-controls="question_properties" aria-selected="false">Question Properties</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="question_design-tab" data-toggle="tab"
                                   href="#question_design" role="tab"
                                   aria-controls="question_design" aria-selected="true">Question Design</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="question_preview-tab" data-toggle="tab"
                                   href="#question_preview" role="tab"
                                   aria-controls="question_design" aria-selected="true">Question Preview</a>
                            </li>


                        </ul>

                        <div class="tab-content" id="myTabContent2">
                            <div class="tab-pane mt-3 fade" id="question_design" role="tabpanel"
                                 aria-labelledby="question_design-tab">
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
                                                                            <li class="leform-pages-bar-item"
                                                                                data-id="1"
                                                                                data-name="Page"><label
                                                                                        onclick="return leform_pages_activate(this);">Page</label><span><a
                                                                                            href="#" data-type="page"
                                                                                            onclick="return leform_properties_open(this);"><i
                                                                                                class="fas fa-cog"></i></a><a
                                                                                            href="#"
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
                                                                                data-type="' . esc_html($key) . '"
                                                                                data-option="2"><a
                                                                                        href="#"
                                                                                        title="' . esc_html($value['title']) . '"><i
                                                                                            class="' . esc_html($value['icon']) . '"></i></a>
                                                                                <ul class="' . esc_html($key) . '">';
                                                                                    foreach ($value['options'] as
                                                                                    $option_key =>
                                                                                    $option_value) {
                                                                                    echo '
                                                                                    <li data-type="' . esc_html($key) . '"
                                                                                        data-option="' . esc_html($option_key) . '"
                                                                                        title=""><a href="#"
                                                                                                    title="' . esc_html($value['title']) . '">'
                                                                                            . esc_html($option_value) .
                                                                                            '</a></li>
                                                                                    ';
                                                                                    }
                                                                                    echo '
                                                                                </ul>
                                                                            </li>
                                                                            ';
                                                                            } else {
                                                                            echo '
                                                                            <li class="leform-toolbar-tool-' . esc_html($value['type']) . '"
                                                                                data-type="' . esc_html($key) . '"><a
                                                                                        href="#"
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
                                                                    <div id="leform-form-1"
                                                                         class="leform-form leform-elements"
                                                                         _data-parent="1" _data-parent-col="0"></div>
                                                                </div>
                                                            </div>
                                                            <iframe data-loading="false" id="leform-import-style-iframe"
                                                                    name="leform-import-style-iframe" src="about:blank"
                                                                    onload="leform_stylemanager_imported(this);"></iframe>
                                                            <form id="leform-import-style-form"
                                                                  enctype="multipart/form-data"
                                                                  method="post" target="leform-import-style-iframe"
                                                                  action="http://baz.com/greenform/?page=leform&leform-action=import-style">
                                                                <input id="leform-import-style-file" type="file"
                                                                       accept=".txt, .zip"
                                                                       name="leform-file"
                                                                       onchange="jQuery('#leform-import-style-iframe').attr('data-loading', 'true'); jQuery('#leform-import-style-form').submit();">
                                                            </form>
                                                            <div class="leform-admin-popup-overlay"
                                                                 id="leform-element-properties-overlay"></div>

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
                                                                                                                        <span title="No icon"
                                                                                                                              onclick="leform_fa_selector_set(this);"><i
                                                                                                                                    class=""></i></span><span
                                                                                title="Star"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-star"></i></span><span
                                                                                title="Star O"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-star-o"></i></span><span
                                                                                title="Check"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-check"></i></span><span
                                                                                title="Close"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-close"></i></span><span
                                                                                title="Lock"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-lock"></i></span><span
                                                                                title="Picture O"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-picture-o"></i></span><span
                                                                                title="Upload"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-upload"></i></span><span
                                                                                title="Download"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-download"></i></span><span
                                                                                title="Calendar"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-calendar"></i></span><span
                                                                                title="Clock O"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-clock-o"></i></span><span
                                                                                title="Chevron Left"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-chevron-left"></i></span><span
                                                                                title="Chevron Right"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-chevron-right"></i></span><span
                                                                                title="Phone"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-phone"></i></span><span
                                                                                title="Envelope"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-envelope"></i></span><span
                                                                                title="Envelope O"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-envelope-o"></i></span><span
                                                                                title="Pencil"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-pencil"></i></span><span
                                                                                title="Angle Double Left"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-angle-double-left"></i></span><span
                                                                                title="Angle Double Right"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-angle-double-right"></i></span><span
                                                                                title="Spinner"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-spinner"></i></span><span
                                                                                title="Smile O"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-smile-o"></i></span><span
                                                                                title="Frown O"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-frown-o"></i></span><span
                                                                                title="Meh O"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-meh-o"></i></span><span
                                                                                title="Send"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-send"></i></span><span
                                                                                title="Send O"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-send-o"></i></span><span
                                                                                title="User"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-user"></i></span><span
                                                                                title="User O"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-user-o"></i></span><span
                                                                                title="Building O"
                                                                                onclick="leform_fa_selector_set(this);"><i
                                                                                    class="leform-fa leform-fa-building-o"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div id="leform-global-message"></div>
                                                            <div class="leform-dialog-overlay"
                                                                 id="leform-dialog-overlay"></div>
                                                            <div class="leform-dialog" id="leform-dialog">
                                                                <div class="leform-dialog-inner">
                                                                    <div class="leform-dialog-title">
                                                                        <a href="#" title="Close"
                                                                           onclick="return leform_dialog_close();"><i
                                                                                    class="fas fa-times"></i></a>
                                                                        <h3><i class="fas fa-cog"></i><label></label>
                                                                        </h3>
                                                                    </div>
                                                                    <div class="leform-dialog-content">
                                                                        <div class="leform-dialog-content-html">
                                                                        </div>
                                                                    </div>
                                                                    <div class="leform-dialog-buttons">
                                                                        <a class="leform-dialog-button leform-dialog-button-ok"
                                                                           href="#"
                                                                           onclick="return false;"><i
                                                                                    class="fas fa-check"></i><label></label></a>
                                                                        <a class="leform-dialog-button leform-dialog-button-cancel"
                                                                           href="#" onclick="return false;"><i
                                                                                    class="fas fa-times"></i><label></label></a>
                                                                    </div>
                                                                    <div class="leform-dialog-loading"><i
                                                                                class="fas fa-spinner fa-spin"></i>
                                                                    </div>
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
                                                                'var leform_form_elements_raw = ""';
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
                                                                }, {
                                                                    "id": "native-41",
                                                                    "name": "Ultra Violet",
                                                                    "type": 1
                                                                }];
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
                                        <div class="lms-element-properties">

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

                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="tab-pane mt-3 fade active show" id="question_properties" role="tabpanel"
                                                             aria-labelledby="question_properties-tab">


                                    <div class="col-12 col-md-12">
                                        <div class="row">


                                            <div class="col-12 col-md-12">
                                                <div class="row">


                                                    <div class="col-12">
                                                        <div class="search-fields-block"
                                                             style="background: #efefef;padding: 10px;">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="input-label">Year / Grade *</label>
                                                                    <select name="category_id" data-plugin-selectTwo
                                                                            class="form-control populate ajax-category-courses">
                                                                        <option value="">All</option>
                                                                        @foreach($categories as $category)
                                                                        @if(!empty($category->subCategories) and
                                                                        count($category->subCategories))
                                                                        <optgroup label="{{  $category->title }}">
                                                                            @foreach($category->subCategories as
                                                                            $subCategory)
                                                                            <option value="{{ $subCategory->id }}"
                                                                                    @if(request()->get('category_id')
                                                                                ==
                                                                                $subCategory->id) selected="selected"
                                                                                @endif>{{ $subCategory->title
                                                                                }}
                                                                            </option>
                                                                            @endforeach
                                                                        </optgroup>
                                                                        @else
                                                                        <option value="{{ $category->id }}" @if(request()->
                                                                            get('category_id') ==
                                                                            $category->id)
                                                                            selected="selected" @endif>{{ $category->title
                                                                            }}
                                                                        </option>
                                                                        @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="input-label">Subject *</label>
                                                                    <select name="course_id"
                                                                            data-plugin-selectTwo
                                                                            class="form-control populate ajax-courses-dropdown">
                                                                        <option value="">Please select year</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="input-label">Topic</label>
                                                                    <select id="chapter_id"
                                                                            class="form-control populate ajax-chapter-dropdown"
                                                                            name="chapter_id">
                                                                        <option value="">Please select year, subject</option>
                                                                    </select>

                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="input-label">Search Keywords / Tags (Enter Search terms which will be use when looking for your questions)</label>
                                                                    <input type="text" data-role="tagsinput"
                                                                           name="search_tags"
                                                                           class="form-control @error('search_tags')  is-invalid @enderror"
                                                                           placeholder="List of comma-Separated Search keywords (i.e. Subject-title, topic)"/>
                                                                    @error('search_tags')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                    <span>5 tags maximum, user letters  and numbers only</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="input-label">Question Reference</label>
                                                            <input type="text" value="{{ old('title') }}"
                                                                   name="question_title"
                                                                   class="form-control @error('title')  is-invalid @enderror"
                                                                   placeholder=""/>
                                                            @error('title')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="input-label">Score</label>
                                                            <input type="text" value="{{ old('title') }}"
                                                                   name="question_score"
                                                                   class="form-control @error('title')  is-invalid @enderror"
                                                                   placeholder=""/>
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
                                                            <input type="text" value="{{ old('title') }}"
                                                                   name="question_average_time"
                                                                   class="form-control @error('title')  is-invalid @enderror"
                                                                   placeholder=""/>
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
                                                                <option value="Below">Below</option>
                                                                <option value="Emerging">Emerging</option>
                                                                <option value="Expected">Expected</option>
                                                                <option value="Exceeding">Exceeding</option>
                                                                <option value="Challenge">Challenge</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group custom-switches-stacked">
                                                            <label class="custom-switch pl-0">
                                                                <input type="hidden" name="review_required" value="disable">
                                                                <input type="checkbox"
                                                                       name="review_required"
                                                                       id="review_required" value="1"
                                                                       class="custom-switch-input"/>
                                                                <span class="custom-switch-indicator"></span>
                                                                <label class="custom-switch-description mb-0 cursor-pointer"
                                                                       for="review_required">Review Required</label>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <div class="form-group">
                                                    <label class="input-label">Glossary</label>
                                                    <select name="glossary_ids[]" id="glossary_ids" class="glossary-items"
                                                            multiple>
                                                        @if(!empty($glossary))
                                                        @foreach($glossary as $glossaryData)
                                                        <option value="{{ $glossaryData->id }}">{{ $glossaryData->title }}
                                                        </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <a href="javascript:;" class="add-glossary-modal">Add New Glossary</a>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <div class="form-group">
                                                    <label class="input-label">Question Example</label>
                                                    <textarea class="note-codable summernote" id="question_example"
                                                              name="question_example"
                                                              aria-multiline="true"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <div class="form-group">
                                                    <label class="input-label">Solution</label>
                                                    <textarea class="note-codable summernote" id="question_solve"
                                                              name="question_solve"
                                                              aria-multiline="true"></textarea>
                                                </div>
                                            </div>
                                            @if(auth()->user()->isAuthor())
                                            <div class="col-12 col-md-12">
                                                <div class="form-group">
                                                    <label class="input-label">Comments for Reviewer</label>
                                                    <textarea class="note-codable summernote" id="comments_for_reviewer"
                                                              name="comments_for_reviewer" aria-multiline="true"></textarea>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            <div class="tab-pane mt-3 fade" id="question_preview" role="tabpanel"
                                 aria-labelledby="question_preview-tab">



                                    <div class="question-area">
                                        <div class="question-step question-step-0" data-elapsed="0"
                                             data-qattempt="0"
                                             data-start_time="0" data-qresult="tstttt111"
                                             data-quiz_result_id="0">
                                            <div class="question-layout-block" style="width: 100%;">

                                                <form class="question-fields" action="javascript:;" data-question_id="0">
                                                    <div class="left-content has-bg">

                                                        <span class="question-number-holder" style="z-index: 999999999;"> <span class="question-number">1</span>
                                                            <span class="question-icon flag-question notflaged" data-qresult_id="1891" data-question_id="837">
                                                                <svg style="width: 42px;height: 42px;" xmlns="http://www.w3.org/2000/svg" version="1.0" width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet"> <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"> <path d="M1620 4674 c-46 -20 -77 -50 -103 -99 l-22 -40 -3 -1842 -2 -1843 -134 0 c-120 0 -137 -2 -177 -23 -24 -13 -57 -43 -74 -66 -27 -39 -30 -50 -30 -120 0 -66 4 -83 25 -114 14 -21 43 -50 64 -65 l39 -27 503 0 502 0 44 30 c138 97 118 306 -34 370 -27 11 -73 15 -168 15 l-130 0 0 750 0 750 1318 2 1319 3 40 28 c83 57 118 184 75 267 -10 19 -140 198 -290 398 -170 225 -270 367 -265 375 4 7 128 174 276 372 149 197 276 374 283 392 19 45 17 120 -5 168 -23 51 -79 101 -128 114 -26 7 -459 11 -1330 11 l-1293 0 0 20 c0 58 -56 137 -122 171 -45 23 -128 25 -178 3z"></path> </g> </svg> </span>
                                                        </span>

                                                        @php $classes = isset( $class )? $class : ''; @endphp
                                                        <div id="leform-form-1"
                                                             class="disable-div"
                                                             _data-parent="1"
                                                             _data-parent-col="0" style="display: block;">
                                                            <div class="question-layout">
                                                                <span class="marks" data-marks="5">5 marks</span>
                                                                <div class="question-layout-data"></div>
                                                            </div>

                                                        </div>
                                                        <div class="show-notifications"></div>

                                                        <div class="prev-next-controls text-center questions-nav-controls">

                                                            @if( !isset( $disable_finish ) || $disable_finish == 'false')
                                                            <a href="javascript:;" data-toggle="modal" class="review-btn {{isset($rev_btn_class)? $rev_btn_class : ''}}" data-target="#review_submit">
                                                                Finish
                                                                <svg style="width: 22px;height: 22px;" xmlns="http://www.w3.org/2000/svg" version="1.0"
                                                                     width="512.000000pt" height="512.000000pt"
                                                                     viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                                                       stroke="none">
                                                                        <path
                                                                                d="M1405 5080 c-350 -40 -655 -161 -975 -388 -18 -13 -21 -9 -48 47 -24 50 -28 70 -24 114 12 153 -150 248 -279 162 -42 -27 -79 -96 -79 -146 0 -47 38 -120 76 -144 18 -11 39 -24 47 -30 9 -5 498 -1013 1088 -2240 589 -1227 1088 -2264 1109 -2305 45 -89 80 -115 142 -107 65 9 115 71 105 132 -3 18 -228 496 -501 1063 -273 566 -496 1034 -496 1038 1 5 29 30 63 55 204 153 442 257 707 311 164 33 453 33 618 0 179 -36 311 -84 537 -197 128 -64 257 -120 330 -144 358 -117 765 -109 1118 19 90 33 130 65 158 125 22 48 24 89 5 141 -34 96 -999 2081 -1024 2107 -66 70 -129 76 -282 27 -181 -57 -256 -70 -415 -77 -170 -6 -278 5 -430 44 -133 34 -213 67 -413 167 -250 125 -368 166 -586 207 -127 23 -421 33 -551 19z m665 -297 c123 -34 232 -79 405 -167 77 -40 163 -81 190 -92 l50 -20 99 -210 c54 -115 101 -215 104 -222 2 -8 -35 6 -84 31 -179 90 -382 152 -576 178 l-93 12 -117 246 c-64 135 -120 255 -124 265 -8 22 -10 22 146 -21z m-814 -297 c74 -154 134 -284 134 -290 0 -6 -28 -22 -62 -35 -131 -49 -324 -161 -447 -260 -35 -29 -68 -48 -72 -44 -9 10 -290 595 -287 598 2 1 30 22 63 47 82 62 206 138 290 178 90 43 216 90 234 87 7 -1 74 -128 147 -281z m2804 -279 c88 -183 135 -290 127 -292 -153 -51 -500 -94 -523 -64 -15 20 -254 525 -254 536 0 6 37 13 82 17 94 8 216 33 333 70 44 13 84 24 88 23 4 -1 71 -132 147 -290z m-1739 -274 l166 -348 -176 -7 c-185 -7 -321 -28 -471 -72 -47 -14 -88 -22 -91 -18 -19 22 -328 687 -322 693 13 11 181 55 278 73 114 20 139 22 310 24 l141 2 165 -347z m729 47 c121 -62 328 -119 506 -140 l101 -12 91 -191 c50 -106 125 -263 167 -351 l75 -158 -67 7 c-186 18 -390 76 -545 154 l-92 46 -109 230 c-60 127 -133 280 -162 342 -59 124 -60 121 35 73z m-321 -451 c131 -27 312 -89 433 -149 57 -28 108 -57 114 -63 14 -15 306 -628 301 -633 -2 -2 -41 15 -88 38 -168 82 -416 155 -593 175 l-69 8 -153 323 c-85 177 -154 325 -154 328 0 9 99 -4 209 -27z m-835 -381 c81 -172 147 -317 146 -323 -2 -5 -40 -24 -84 -41 -164 -63 -298 -135 -431 -231 -32 -24 -62 -43 -65 -43 -6 0 -75 140 -236 477 l-63 132 62 49 c139 108 281 193 437 259 41 18 77 32 80 33 3 0 72 -141 154 -312z m2811 -281 l154 -318 -27 -10 c-106 -41 -319 -79 -438 -79 l-71 0 -152 321 c-84 176 -151 323 -148 325 2 3 66 9 141 14 124 9 296 39 350 60 12 5 25 8 30 6 4 -1 77 -145 161 -319z"></path>
                                                                    </g>
                                                                </svg>
                                                            </a>
                                                            @endif

                                                            @php $prev_class = (isset( $prev_question ) && $prev_question > 0)? '' : ''; @endphp
                                                            @if( !isset( $disable_prev ) || $disable_prev == 'false')
                                                            <a href="javascript:;" id="prev-btn" class="{{$prev_class}} prev-btn {{isset( $prev_btn_class)? $prev_btn_class : ''}}"
                                                               data-question_id="0">
                                                                <svg style="width: 22px;height: 22px;" xmlns="http://www.w3.org/2000/svg" version="1.0"
                                                                     width="512.000000pt" height="512.000000pt"
                                                                     viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                                                       stroke="none">
                                                                        <path
                                                                                d="M3620 5103 c-39 -13 -198 -168 -1238 -1207 -1095 -1093 -1194 -1195 -1212 -1244 -25 -67 -25 -117 0 -184 18 -49 117 -151 1212 -1244 1141 -1140 1195 -1193 1247 -1209 214 -69 408 147 315 352 -11 25 -377 398 -1093 1115 l-1076 1078 1076 1077 c701 703 1082 1091 1093 1115 61 135 -4 297 -140 348 -64 23 -121 24 -184 3z"></path>
                                                                    </g>
                                                                </svg>
                                                            </a>
                                                            @endif
                                                            @php $next_class = (isset( $next_question ) && $next_question > 0)? '' : ''; @endphp
                                                            @if( !isset( $disable_next ) || $disable_next == 'false')
                                                            <a href="javascript:;" id="next-btn" class="{{$next_class}} next-btn {{isset( $next_btn_class)? $next_btn_class : ''}}"
                                                               data-question_id="0">
                                                                Next
                                                                <svg style="width: 22px;height: 22px;" xmlns="http://www.w3.org/2000/svg" version="1.0"
                                                                     width="512.000000pt" height="512.000000pt"
                                                                     viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                                                       stroke="none">
                                                                        <path
                                                                                d="M1340 5111 c-118 -36 -200 -156 -187 -272 3 -27 14 -66 23 -86 11 -25 377 -398 1093 -1116 l1076 -1077 -1076 -1078 c-716 -717 -1082 -1090 -1093 -1115 -61 -135 4 -296 140 -347 66 -24 114 -25 180 -4 45 15 146 113 1242 1208 1095 1093 1194 1195 1212 1244 11 29 20 70 20 92 0 22 -9 63 -20 92 -18 49 -117 151 -1212 1244 -1096 1095 -1197 1193 -1242 1208 -52 17 -114 20 -156 7z"></path>
                                                                    </g>
                                                                </svg>
                                                            </a>
                                                            @endif
                                                            @if( !isset( $disable_submit ) || $disable_submit == 'false')
                                                            <a href="javascript:;" id="question-submit-btn" class="question-submit-btn {{isset( $submit_class)? $submit_class : ''}}">
                                                                mark answer
                                                                <svg style="width: 22px;height: 22px;" xmlns="http://www.w3.org/2000/svg" version="1.0"
                                                                     width="512.000000pt" height="512.000000pt"
                                                                     viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                                                       stroke="none">
                                                                        <path
                                                                                d="M1405 5080 c-350 -40 -655 -161 -975 -388 -18 -13 -21 -9 -48 47 -24 50 -28 70 -24 114 12 153 -150 248 -279 162 -42 -27 -79 -96 -79 -146 0 -47 38 -120 76 -144 18 -11 39 -24 47 -30 9 -5 498 -1013 1088 -2240 589 -1227 1088 -2264 1109 -2305 45 -89 80 -115 142 -107 65 9 115 71 105 132 -3 18 -228 496 -501 1063 -273 566 -496 1034 -496 1038 1 5 29 30 63 55 204 153 442 257 707 311 164 33 453 33 618 0 179 -36 311 -84 537 -197 128 -64 257 -120 330 -144 358 -117 765 -109 1118 19 90 33 130 65 158 125 22 48 24 89 5 141 -34 96 -999 2081 -1024 2107 -66 70 -129 76 -282 27 -181 -57 -256 -70 -415 -77 -170 -6 -278 5 -430 44 -133 34 -213 67 -413 167 -250 125 -368 166 -586 207 -127 23 -421 33 -551 19z m665 -297 c123 -34 232 -79 405 -167 77 -40 163 -81 190 -92 l50 -20 99 -210 c54 -115 101 -215 104 -222 2 -8 -35 6 -84 31 -179 90 -382 152 -576 178 l-93 12 -117 246 c-64 135 -120 255 -124 265 -8 22 -10 22 146 -21z m-814 -297 c74 -154 134 -284 134 -290 0 -6 -28 -22 -62 -35 -131 -49 -324 -161 -447 -260 -35 -29 -68 -48 -72 -44 -9 10 -290 595 -287 598 2 1 30 22 63 47 82 62 206 138 290 178 90 43 216 90 234 87 7 -1 74 -128 147 -281z m2804 -279 c88 -183 135 -290 127 -292 -153 -51 -500 -94 -523 -64 -15 20 -254 525 -254 536 0 6 37 13 82 17 94 8 216 33 333 70 44 13 84 24 88 23 4 -1 71 -132 147 -290z m-1739 -274 l166 -348 -176 -7 c-185 -7 -321 -28 -471 -72 -47 -14 -88 -22 -91 -18 -19 22 -328 687 -322 693 13 11 181 55 278 73 114 20 139 22 310 24 l141 2 165 -347z m729 47 c121 -62 328 -119 506 -140 l101 -12 91 -191 c50 -106 125 -263 167 -351 l75 -158 -67 7 c-186 18 -390 76 -545 154 l-92 46 -109 230 c-60 127 -133 280 -162 342 -59 124 -60 121 35 73z m-321 -451 c131 -27 312 -89 433 -149 57 -28 108 -57 114 -63 14 -15 306 -628 301 -633 -2 -2 -41 15 -88 38 -168 82 -416 155 -593 175 l-69 8 -153 323 c-85 177 -154 325 -154 328 0 9 99 -4 209 -27z m-835 -381 c81 -172 147 -317 146 -323 -2 -5 -40 -24 -84 -41 -164 -63 -298 -135 -431 -231 -32 -24 -62 -43 -65 -43 -6 0 -75 140 -236 477 l-63 132 62 49 c139 108 281 193 437 259 41 18 77 32 80 33 3 0 72 -141 154 -312z m2811 -281 l154 -318 -27 -10 c-106 -41 -319 -79 -438 -79 l-71 0 -152 321 c-84 176 -151 323 -148 325 2 3 66 9 141 14 124 9 296 39 350 60 12 5 25 8 30 6 4 -1 77 -145 161 -319z"></path>
                                                                    </g>
                                                                </svg>
                                                            </a>


                                                            @endif
                                                        </div>
                                                    </div>


                                                </form>

                                            </div>
                                        </div>

                                    </div>




                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12 col-md-12">


            @include('admin.questions_bank.question_editor_fields_controls')


            <div class="mt-5 mb-5 create-question-fields-block">
                <button type="button" data-status="Draft" class="quiz-stage-generate btn btn-warning">Draft</button>
                <button type="button" data-status="Submit for review" class="quiz-stage-generate btn btn-primary">
                    Submit for review
                </button>
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

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
<script src="/assets/vendors/summernote/summernote-table-headers.js"></script>
<script src="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

<script type="text/javascript">

    $(document).ready(function () {

        $('.glossary-items').select2();
        $(".question-no-field").draggable({
            containment: ".leform-builder",
        });

    });

    var saveSuccessLang = '{{ trans("webinars.success_store") }}';
</script>


<script src="/assets/default/js/admin/quiz.min.js"></script>
<script type="text/javascript">
    $("body").on("click", ".add-glossary-modal", function (t) {
        $("#add-glosary-modal-box").modal({backdrop: "static"});
    });

    $(document).on('change', '.ajax-category-courses', function () {
        var category_id = $(this).val();
        $.ajax({
            type: "GET",
            url: '/admin/webinars/courses_by_categories',
            data: {'category_id': category_id},
            success: function (return_data) {
                $(".ajax-courses-dropdown").html(return_data);
                $(".ajax-chapter-dropdown").html('<option value="">Please select year, subject</option>');
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

    $(document).on('click', '#question_preview-tab', function () {

        var question_layout = $(".leform-form");
        question_layout.find('.editor-field').each(function () {
            $.each($(this).data(), function (i) {
                if (i != 'style') {
                    question_layout.find('.editor-field').removeAttr("data-" + i);
                }
            });
        });

        question_layout.find('.editor-field').removeAttr("correct_answere");
        $(".question-layout-data").html(question_layout.html());
        var question_score = $("[name=question_score]").val();
        $(".question-layout .marks").html(question_score+' marks');
        var question_layout = leform_encode64(JSON.stringify(question_layout.html()));
        console.log(question_layout);

    });


</script>

@endpush
