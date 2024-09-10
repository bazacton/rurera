@extends('admin.layouts.app')
@php
$toolbar_tools  = toolbar_tools();
$element_properties_meta    = element_properties_meta($chapters);
$tabs_options    = tabs_options();


@endphp


@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
<link rel="stylesheet" href="/assets/default/css/quiz-create.css">
<link href="/assets/default/css/jquery-ui/jquery-ui.min.css" rel="stylesheet">
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<script src="/assets/default/js/admin/jquery.min.js"></script>
<script src="/assets/default/js/admin/question-create.js"></script>

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
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label class="input-label">Question Title</label>
                            <input type="text" value="{{ $question_title }}" name="question_title" class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label class="input-label">Chapter</label>


                            <select id="chapters" class="custom-select @error('category_id')  is-invalid @enderror" name="chapter_id">
                                @foreach($chapters as $chapter_id => $chapterData)
                                @if(!empty($chapterData['chapters']) and count($chapterData['chapters']))
                                <optgroup label="{{  $chapterData['title'] }}">
                                    @foreach($chapterData['chapters'] as $sub_chapter_id => $sub_chapter_title)
                                    <option value="{{ $sub_chapter_id }}" {{ ($sub_chapter_id == $chapter_db_id) ? 'selected' : '' }}>{{ $sub_chapter_title }}</option>
                                    @endforeach
                                </optgroup>
                                @else
                                <option value="{{ $chapter_id }}">{{ $chapterData['title'] }}</option>
                                @endif
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label class="input-label">Score</label>
                            <input type="text" value="{{ $question_score }}" name="question_score" class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="form-group">
                            <label class="input-label">Average Time</label>
                            <input type="text" value="{{ $question_average_time }}" name="question_average_time" class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="form-group">
                            <label class="input-label">Difficulty Level</label>
                            <select name="difficulty_level" class="custom-select ">
                                <option value="Below" {{ ($question_difficulty_level == 'Below') ? 'selected' : '' }}>Below</option>
                                <option value="Emerging" {{ ($question_difficulty_level == 'Emerging') ? 'selected' : '' }}>Emerging</option>
                                <option value="Expected" {{ ($question_difficulty_level == 'Expected') ? 'selected' : '' }}>Expected</option>
                                <option value="Exceeding" {{ ($question_difficulty_level == 'Exceeding') ? 'selected' : '' }}>Exceeding</option>
                                <option value="Challenge" {{ ($question_difficulty_level == 'Challenge') ? 'selected' : '' }}>Challenge</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="form-group">
                            <label class="input-label">Explanation</label>
                            <textarea class="note-codable summernote" id="question_explanation" name="question_explanation" aria-multiline="true">{{$question_explanation}}</textarea>
                        </div>
                    </div>
                    
                    <div class="col-6 col-md-4">
                        <div class="form-group">
                            <label class="input-label">Remember</label>
                            <textarea class="note-codable summernote" id="question_remember" name="question_remember" aria-multiline="true">{{$question_remember}}</textarea>
                        </div>
                    </div>
                    
                    <div class="col-6 col-md-4">
                        <div class="form-group">
                            <label class="input-label">Solve</label>
                            <textarea class="note-codable summernote" id="question_solve" name="question_solve" aria-multiline="true">{{$question_solve}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="hap-container">
                    <div class="hap-content">
                        <div class="hap-content-area">
                            <div id="global-message-container">
                            </div>
                            <div class="hap-content-box">
                                <script>rureraform_gettingstarted_enable = "off";</script>
                                <div class="wrap rureraform-admin rureraform-admin-editor">
                                    <div class="rureraform-form-editor">
                                        <div class="rureraform-toolbars">
                                            <div class="rureraform-header">

                                            </div>
                                            <div class="rureraform-pages-bar">
                                                <ul class="rureraform-pages-bar-items hide">
                                                    <li class="rureraform-pages-bar-item" data-id="1" data-name="Page"><label onclick="return rureraform_pages_activate(this);">Page</label><span><a href="#" data-type="page" onclick="return rureraform_properties_open(this);"><i class="fas fa-cog"></i></a><a href="#" class="rureraform-pages-bar-item-delete rureraform-pages-bar-item-delete-disabled" onclick="return rureraform_pages_delete(this);"><i class="fas fa-trash-alt"></i></a></span></li>
                                                </ul>
                                            </div>
                                            <div class="rureraform-toolbar">
                                                <ul class="rureraform-toolbar-list">
                                                    @php
                                                    foreach ($toolbar_tools as $key => $value) {
                                                    if (array_key_exists('options', $value)) {
                                                    echo '
                                                    <li class="rureraform-toolbar-tool-' . esc_html($value['type']) . '" class="rureraform-toolbar-list-options" data-type="' . esc_html($key) . '" data-option="2"><a href="#" title="' . esc_html($value['title']) . '"><i class="' . esc_html($value['icon']) . '"></i></a><ul>';
                                                            foreach ($value['options'] as $option_key => $option_value) {
                                                            echo '<li data-type="' . esc_html($key) . '" data-option="' . esc_html($option_key) . '" title=""><a href="#" title="' . esc_html($value['title']) . '">' . esc_html($option_value) . '</a></li>';
                                                            }
                                                            echo '</ul></li>';
                                                    } else {
                                                    echo '
                                                    <li class="rureraform-toolbar-tool-' . esc_html($value['type']) . '" data-type="' . esc_html($key) . '"><a href="#" title="' . esc_html($value['title']) . '"><i class="' . esc_html($value['icon']) . '"></i></a></li>';
                                                    }
                                                    }
                                                    @endphp

                                                </ul>
                                            </div>
                                        </div>
                                        <div class="rureraform-builder"><div class="rureraform-form-global-style"></div>
                                            <div id="rureraform-form-1" class="rureraform-form rureraform-elements" _data-parent="1" _data-parent-col="0"></div>
                                        </div>
                                    </div>
                                    <iframe data-loading="false" id="rureraform-import-style-iframe" name="rureraform-import-style-iframe" src="about:blank" onload="rureraform_stylemanager_imported(this);"></iframe>
                                    <form id="rureraform-import-style-form" enctype="multipart/form-data" method="post" target="rureraform-import-style-iframe" action="http://baz.com/greenform/?page=rureraform&rureraform-action=import-style">
                                        <input id="rureraform-import-style-file" type="file" accept=".txt, .zip" name="rureraform-file" onchange="jQuery('#rureraform-import-style-iframe').attr('data-loading', 'true'); jQuery('#rureraform-import-style-form').submit();">
                                    </form>
                                    <div class="rureraform-admin-popup-overlay" id="rureraform-element-properties-overlay"></div>
                                    <div class="rureraform-admin-popup" id="rureraform-element-properties">
                                        <div class="rureraform-admin-popup-inner">
                                            <div class="rureraform-admin-popup-title">
                                                <a href="#" title="Close" onclick="return rureraform_properties_close();"><i class="fas fa-times"></i></a>
                                                <h3><i class="fas fa-cog"></i> Element Properties</h3>
                                            </div>
                                            <div class="rureraform-admin-popup-content">
                                                <div class="rureraform-admin-popup-content-form">
                                                </div>
                                            </div>
                                            <div class="rureraform-admin-popup-buttons">
                                                <a class="rureraform-admin-button generate-question-code" href="#"><i class="fas fa-check"></i><label>Save Details</label></a>
                                            </div>
                                            <div class="rureraform-admin-popup-loading"><i class="fas fa-spinner fa-spin"></i></div>
                                        </div>
                                    </div>
                                    <div class="rureraform-fa-selector-overlay"></div>
                                    <div class="rureraform-fa-selector">
                                        <div class="rureraform-fa-selector-inner">
                                            <div class="rureraform-fa-selector-header">
                                                <a href="#" title="Close" onclick="return rureraform_fa_selector_close();"><i class="fas fa-times"></i></a>
                                                <input type="text" placeholder="Search...">
                                            </div>
                                            <div class="rureraform-fa-selector-content">
                                                <span title="No icon" onclick="rureraform_fa_selector_set(this);"><i class=""></i></span><span title="Star" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-star"></i></span><span title="Star O" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-star-o"></i></span><span title="Check" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-check"></i></span><span title="Close" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-close"></i></span><span title="Lock" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-lock"></i></span><span title="Picture O" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-picture-o"></i></span><span title="Upload" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-upload"></i></span><span title="Download" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-download"></i></span><span title="Calendar" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-calendar"></i></span><span title="Clock O" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-clock-o"></i></span><span title="Chevron Left" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-chevron-left"></i></span><span title="Chevron Right" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-chevron-right"></i></span><span title="Phone" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-phone"></i></span><span title="Envelope" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-envelope"></i></span><span title="Envelope O" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-envelope-o"></i></span><span title="Pencil" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-pencil"></i></span><span title="Angle Double Left" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-angle-double-left"></i></span><span title="Angle Double Right" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-angle-double-right"></i></span><span title="Spinner" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-spinner"></i></span><span title="Smile O" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-smile-o"></i></span><span title="Frown O" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-frown-o"></i></span><span title="Meh O" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-meh-o"></i></span><span title="Send" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-send"></i></span><span title="Send O" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-send-o"></i></span><span title="User" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-user"></i></span><span title="User O" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-user-o"></i></span><span title="Building O" onclick="rureraform_fa_selector_set(this);"><i class="rureraform-fa rureraform-fa-building-o"></i></span>
                                            </div>
                                        </div>
                                    </div>



                                    <div id="rureraform-global-message"></div>
                                    <div class="rureraform-dialog-overlay" id="rureraform-dialog-overlay"></div>
                                    <div class="rureraform-dialog" id="rureraform-dialog">
                                        <div class="rureraform-dialog-inner">
                                            <div class="rureraform-dialog-title">
                                                <a href="#" title="Close" onclick="return rureraform_dialog_close();"><i class="fas fa-times"></i></a>
                                                <h3><i class="fas fa-cog"></i><label></label></h3>
                                            </div>
                                            <div class="rureraform-dialog-content">
                                                <div class="rureraform-dialog-content-html">
                                                </div>
                                            </div>
                                            <div class="rureraform-dialog-buttons">
                                                <a class="rureraform-dialog-button rureraform-dialog-button-ok" href="#" onclick="return false;"><i class="fas fa-check"></i><label></label></a>
                                                <a class="rureraform-dialog-button rureraform-dialog-button-cancel" href="#" onclick="return false;"><i class="fas fa-times"></i><label></label></a>
                                            </div>
                                            <div class="rureraform-dialog-loading"><i class="fas fa-spinner fa-spin"></i></div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="rureraform-id" value="3" />
                                    <script>
                                        var rureraform_webfonts = ["ABeeZee", "Abel", "Abhaya Libre", "Abril Fatface", "Aclonica", "Acme", "Actor", "Adamina", "Advent Pro", "Aguafina Script", "Akronim", "Aladin", "Alata", "Alatsi", "Aldrich", "Alef", "Alegreya", "Alegreya Sans", "Alegreya Sans SC", "Alegreya SC", "Aleo", "Alex Brush", "Alfa Slab One", "Alice", "Alike", "Alike Angular", "Allan", "Allerta", "Allerta Stencil", "Allura", "Almarai", "Almendra", "Almendra Display", "Almendra SC", "Amarante", "Amaranth", "Amatic SC", "Amethysta", "Amiko", "Amiri", "Amita", "Anaheim", "Andada", "Andika", "Andika New Basic", "Angkor", "Annie Use Your Telescope", "Anonymous Pro", "Antic", "Antic Didone", "Antic Slab", "Anton", "Arapey", "Arbutus", "Arbutus Slab", "Architects Daughter", "Archivo", "Archivo Black", "Archivo Narrow", "Aref Ruqaa", "Arima Madurai", "Arimo", "Arizonia", "Armata", "Arsenal", "Artifika", "Arvo", "Arya", "Asap", "Asap Condensed", "Asar", "Asset", "Assistant", "Astloch", "Asul", "Athiti", "Atma", "Atomic Age", "Aubrey", "Audiowide", "Autour One", "Average", "Average Sans", "Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre", "Averia Serif Libre", "B612", "B612 Mono", "Bad Script", "Bahiana", "Bahianita", "Bai Jamjuree", "Baloo 2", "Baloo Bhai 2", "Baloo Bhaina 2", "Baloo Chettan 2", "Baloo Da 2", "Baloo Paaji 2", "Baloo Tamma 2", "Baloo Tammudu 2", "Baloo Thambi 2", "Balsamiq Sans", "Balthazar", "Bangers", "Barlow", "Barlow Condensed", "Barlow Semi Condensed", "Barriecito", "Barrio", "Basic", "Baskervville", "Battambang", "Baumans", "Bayon", "Be Vietnam", "Bebas Neue", "Belgrano", "Bellefair", "Belleza", "Bellota", "Bellota Text", "BenchNine", "Bentham", "Berkshire Swash", "Beth Ellen", "Bevan", "Big Shoulders Display", "Big Shoulders Inline Display", "Big Shoulders Inline Text", "Big Shoulders Stencil Display", "Big Shoulders Stencil Text", "Big Shoulders Text", "Bigelow Rules", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "BioRhyme", "BioRhyme Expanded", "Biryani", "Bitter", "Black And White Picture", "Black Han Sans", "Black Ops One", "Blinker", "Bodoni Moda", "Bokor", "Bonbon", "Boogaloo", "Bowlby One", "Bowlby One SC", "Brawler", "Bree Serif", "Bubblegum Sans", "Bubbler One", "Buda", "Buenard", "Bungee", "Bungee Hairline", "Bungee Inline", "Bungee Outline", "Bungee Shade", "Butcherman", "Butterfly Kids", "Cabin", "Cabin Condensed", "Cabin Sketch", "Caesar Dressing", "Cagliostro", "Cairo", "Caladea", "Calistoga", "Calligraffitti", "Cambay", "Cambo", "Candal", "Cantarell", "Cantata One", "Cantora One", "Capriola", "Cardo", "Carme", "Carrois Gothic", "Carrois Gothic SC", "Carter One", "Castoro", "Catamaran", "Caudex", "Caveat", "Caveat Brush", "Cedarville Cursive", "Ceviche One", "Chakra Petch", "Changa", "Changa One", "Chango", "Charm", "Charmonman", "Chathura", "Chau Philomene One", "Chela One", "Chelsea Market", "Chenla", "Cherry Cream Soda", "Cherry Swash", "Chewy", "Chicle", "Chilanka", "Chivo", "Chonburi", "Cinzel", "Cinzel Decorative", "Clicker Script", "Coda", "Coda Caption", "Codystar", "Coiny", "Combo", "Comfortaa", "Comic Neue", "Coming Soon", "Commissioner", "Concert One", "Condiment", "Content", "Contrail One", "Convergence", "Cookie", "Copse", "Corben", "Cormorant", "Cormorant Garamond", "Cormorant Infant", "Cormorant SC", "Cormorant Unicase", "Cormorant Upright", "Courgette", "Courier Prime", "Cousine", "Coustard", "Covered By Your Grace", "Crafty Girls", "Creepster", "Crete Round", "Crimson Pro", "Crimson Text", "Croissant One", "Crushed", "Cuprum", "Cute Font", "Cutive", "Cutive Mono", "Damion", "Dancing Script", "Dangrek", "Darker Grotesque", "David Libre", "Dawning of a New Day", "Days One", "Dekko", "Delius", "Delius Swash Caps", "Delius Unicase", "Della Respira", "Denk One", "Devonshire", "Dhurjati", "Didact Gothic", "Diplomata", "Diplomata SC", "DM Mono", "DM Sans", "DM Serif Display", "DM Serif Text", "Do Hyeon", "Dokdo", "Domine", "Donegal One", "Doppio One", "Dorsa", "Dosis", "Dr Sugiyama", "Duru Sans", "Dynalight", "Eagle Lake", "East Sea Dokdo", "Eater", "EB Garamond", "Economica", "Eczar", "El Messiri", "Electrolize", "Elsie", "Elsie Swash Caps", "Emblema One", "Emilys Candy", "Encode Sans", "Encode Sans Condensed", "Encode Sans Expanded", "Encode Sans Semi Condensed", "Encode Sans Semi Expanded", "Engagement", "Englebert", "Enriqueta", "Epilogue", "Erica One", "Esteban", "Euphoria Script", "Ewert", "Exo", "Exo 2", "Expletus Sans", "Fahkwang", "Fanwood Text", "Farro", "Farsan", "Fascinate", "Fascinate Inline", "Faster One", "Fasthand", "Fauna One", "Faustina", "Federant", "Federo", "Felipa", "Fenix", "Finger Paint", "Fira Code", "Fira Mono", "Fira Sans", "Fira Sans Condensed", "Fira Sans Extra Condensed", "Fjalla One", "Fjord One", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky", "Forum", "Francois One", "Frank Ruhl Libre", "Fraunces", "Freckle Face", "Fredericka the Great", "Fredoka One", "Freehand", "Fresca", "Frijole", "Fruktur", "Fugaz One", "Gabriela", "Gaegu", "Gafata", "Galada", "Galdeano", "Galindo", "Gamja Flower", "Gayathri", "Gelasio", "Gentium Basic", "Gentium Book Basic", "Geo", "Geostar", "Geostar Fill", "Germania One", "GFS Didot", "GFS Neohellenic", "Gidugu", "Gilda Display", "Girassol", "Give You Glory", "Glass Antiqua", "Glegoo", "Gloria Hallelujah", "Goblin One", "Gochi Hand", "Goldman", "Gorditas", "Gothic A1", "Gotu", "Goudy Bookletter 1911", "Graduate", "Grand Hotel", "Grandstander", "Gravitas One", "Great Vibes", "Grenze", "Grenze Gotisch", "Griffy", "Gruppo", "Gudea", "Gugi", "Gupter", "Gurajada", "Habibi", "Hachi Maru Pop", "Halant", "Hammersmith One", "Hanalei", "Hanalei Fill", "Handlee", "Hanuman", "Happy Monkey", "Harmattan", "Headland One", "Heebo", "Henny Penny", "Hepta Slab", "Herr Von Muellerhoff", "Hi Melody", "Hind", "Hind Guntur", "Hind Madurai", "Hind Siliguri", "Hind Vadodara", "Holtwood One SC", "Homemade Apple", "Homenaje", "Ibarra Real Nova", "IBM Plex Mono", "IBM Plex Sans", "IBM Plex Sans Condensed", "IBM Plex Serif", "Iceberg", "Iceland", "IM Fell Double Pica", "IM Fell Double Pica SC", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer", "IM Fell Great Primer SC", "Imbue", "Imprima", "Inconsolata", "Inder", "Indie Flower", "Inika", "Inknut Antiqua", "Inria Sans", "Inria Serif", "Inter", "Irish Grover", "Istok Web", "Italiana", "Italianno", "Itim", "Jacques Francois", "Jacques Francois Shadow", "Jaldi", "JetBrains Mono", "Jim Nightshade", "Jockey One", "Jolly Lodger", "Jomhuria", "Jomolhari", "Josefin Sans", "Josefin Slab", "Jost", "Joti One", "Jua", "Judson", "Julee", "Julius Sans One", "Junge", "Jura", "Just Another Hand", "Just Me Again Down Here", "K2D", "Kadwa", "Kalam", "Kameron", "Kanit", "Kantumruy", "Karla", "Karma", "Katibeh", "Kaushan Script", "Kavivanar", "Kavoon", "Kdam Thmor", "Keania One", "Kelly Slab", "Kenia", "Khand", "Khmer", "Khula", "Kirang Haerang", "Kite One", "Knewave", "Kodchasan", "KoHo", "Kosugi", "Kosugi Maru", "Kotta One", "Koulen", "Kranky", "Kreon", "Kristi", "Krona One", "Krub", "Kufam", "Kulim Park", "Kumar One", "Kumar One Outline", "Kumbh Sans", "Kurale", "La Belle Aurore", "Lacquer", "Laila", "Lakki Reddy", "Lalezar", "Lancelot", "Langar", "Lateef", "Lato", "League Script", "Leckerli One", "Ledger", "Lekton", "Lemon", "Lemonada", "Lexend Deca", "Lexend Exa", "Lexend Giga", "Lexend Mega", "Lexend Peta", "Lexend Tera", "Lexend Zetta", "Libre Barcode 128", "Libre Barcode 128 Text", "Libre Barcode 39", "Libre Barcode 39 Extended", "Libre Barcode 39 Extended Text", "Libre Barcode 39 Text", "Libre Barcode EAN13 Text", "Libre Baskerville", "Libre Caslon Display", "Libre Caslon Text", "Libre Franklin", "Life Savers", "Lilita One", "Lily Script One", "Limelight", "Linden Hill", "Literata", "Liu Jian Mao Cao", "Livvic", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow", "Londrina Sketch", "Londrina Solid", "Long Cang", "Lora", "Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel", "Luckiest Guy", "Lusitana", "Lustria", "M PLUS 1p", "M PLUS Rounded 1c", "Ma Shan Zheng", "Macondo", "Macondo Swash Caps", "Mada", "Magra", "Maiden Orange", "Maitree", "Major Mono Display", "Mako", "Mali", "Mallanna", "Mandali", "Manjari", "Manrope", "Mansalva", "Manuale", "Marcellus", "Marcellus SC", "Marck Script", "Margarine", "Markazi Text", "Marko One", "Marmelad", "Martel", "Martel Sans", "Marvel", "Mate", "Mate SC", "Maven Pro", "McLaren", "Meddon", "MedievalSharp", "Medula One", "Meera Inimai", "Megrim", "Meie Script", "Merienda", "Merienda One", "Merriweather", "Merriweather Sans", "Metal", "Metal Mania", "Metamorphous", "Metrophobic", "Michroma", "Milonga", "Miltonian", "Miltonian Tattoo", "Mina", "Miniver", "Miriam Libre", "Mirza", "Miss Fajardose", "Mitr", "Modak", "Modern Antiqua", "Mogra", "Molengo", "Molle", "Monda", "Monofett", "Monoton", "Monsieur La Doulaise", "Montaga", "Montez", "Montserrat", "Montserrat Alternates", "Montserrat Subrayada", "Moul", "Moulpali", "Mountains of Christmas", "Mouse Memoirs", "Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards", "Mukta", "Mukta Mahee", "Mukta Malar", "Mukta Vaani", "Mulish", "MuseoModerno", "Mystery Quest", "Nanum Brush Script", "Nanum Gothic", "Nanum Gothic Coding", "Nanum Myeongjo", "Nanum Pen Script", "Nerko One", "Neucha", "Neuton", "New Rocker", "News Cycle", "Niconne", "Niramit", "Nixie One", "Nobile", "Nokora", "Norican", "Nosifer", "Notable", "Nothing You Could Do", "Noticia Text", "Noto Sans", "Noto Sans HK", "Noto Sans JP", "Noto Sans KR", "Noto Sans SC", "Noto Sans TC", "Noto Serif", "Noto Serif JP", "Noto Serif KR", "Noto Serif SC", "Noto Serif TC", "Nova Cut", "Nova Flat", "Nova Mono", "Nova Oval", "Nova Round", "Nova Script", "Nova Slim", "Nova Square", "NTR", "Numans", "Nunito", "Nunito Sans", "Odibee Sans", "Odor Mean Chey", "Offside", "Old Standard TT", "Oldenburg", "Oleo Script", "Oleo Script Swash Caps", "Open Sans", "Open Sans Condensed", "Oranienbaum", "Orbitron", "Oregano", "Orienta", "Original Surfer", "Oswald", "Over the Rainbow", "Overlock", "Overlock SC", "Overpass", "Overpass Mono", "Ovo", "Oxanium", "Oxygen", "Oxygen Mono", "Pacifico", "Padauk", "Palanquin", "Palanquin Dark", "Pangolin", "Paprika", "Parisienne", "Passero One", "Passion One", "Pathway Gothic One", "Patrick Hand", "Patrick Hand SC", "Pattaya", "Patua One", "Pavanam", "Paytone One", "Peddana", "Peralta", "Permanent Marker", "Petit Formal Script", "Petrona", "Philosopher", "Piazzolla", "Piedra", "Pinyon Script", "Pirata One", "Plaster", "Play", "Playball", "Playfair Display", "Playfair Display SC", "Podkova", "Poiret One", "Poller One", "Poly", "Pompiere", "Pontano Sans", "Poor Story", "Poppins", "Port Lligat Sans", "Port Lligat Slab", "Potta One", "Pragati Narrow", "Prata", "Preahvihear", "Press Start 2P", "Pridi", "Princess Sofia", "Prociono", "Prompt", "Prosto One", "Proza Libre", "PT Mono", "PT Sans", "PT Sans Caption", "PT Sans Narrow", "PT Serif", "PT Serif Caption", "Public Sans", "Puritan", "Purple Purse", "Quando", "Quantico", "Quattrocento", "Quattrocento Sans", "Questrial", "Quicksand", "Quintessential", "Qwigley", "Racing Sans One", "Radley", "Rajdhani", "Rakkas", "Raleway", "Raleway Dots", "Ramabhadra", "Ramaraja", "Rambla", "Rammetto One", "Ranchers", "Rancho", "Ranga", "Rasa", "Rationale", "Ravi Prakash", "Recursive", "Red Hat Display", "Red Hat Text", "Red Rose", "Redressed", "Reem Kufi", "Reenie Beanie", "Revalia", "Rhodium Libre", "Ribeye", "Ribeye Marrow", "Righteous", "Risque", "Roboto", "Roboto Condensed", "Roboto Mono", "Roboto Slab", "Rochester", "Rock Salt", "Rokkitt", "Romanesco", "Ropa Sans", "Rosario", "Rosarivo", "Rouge Script", "Rowdies", "Rozha One", "Rubik", "Rubik Mono One", "Ruda", "Rufina", "Ruge Boogie", "Ruluko", "Rum Raisin", "Ruslan Display", "Russo One", "Ruthie", "Rye", "Sacramento", "Sahitya", "Sail", "Saira", "Saira Condensed", "Saira Extra Condensed", "Saira Semi Condensed", "Saira Stencil One", "Salsa", "Sanchez", "Sancreek", "Sansita", "Sansita Swashed", "Sarabun", "Sarala", "Sarina", "Sarpanch", "Satisfy", "Sawarabi Gothic", "Sawarabi Mincho", "Scada", "Scheherazade", "Schoolbell", "Scope One", "Seaweed Script", "Secular One", "Sedgwick Ave", "Sedgwick Ave Display", "Sen", "Sevillana", "Seymour One", "Shadows Into Light", "Shadows Into Light Two", "Shanti", "Share", "Share Tech", "Share Tech Mono", "Shojumaru", "Short Stack", "Shrikhand", "Siemreap", "Sigmar One", "Signika", "Signika Negative", "Simonetta", "Single Day", "Sintony", "Sirin Stencil", "Six Caps", "Skranji", "Slabo 13px", "Slabo 27px", "Slackey", "Smokum", "Smythe", "Sniglet", "Snippet", "Snowburst One", "Sofadi One", "Sofia", "Solway", "Song Myung", "Sonsie One", "Sora", "Sorts Mill Goudy", "Source Code Pro", "Source Sans Pro", "Source Serif Pro", "Space Grotesk", "Space Mono", "Spartan", "Special Elite", "Spectral", "Spectral SC", "Spicy Rice", "Spinnaker", "Spirax", "Squada One", "Sree Krushnadevaraya", "Sriracha", "Srisakdi", "Staatliches", "Stalemate", "Stalinist One", "Stardos Stencil", "Stint Ultra Condensed", "Stint Ultra Expanded", "Stoke", "Strait", "Stylish", "Sue Ellen Francisco", "Suez One", "Sulphur Point", "Sumana", "Sunflower", "Sunshiney", "Supermercado One", "Sura", "Suranna", "Suravaram", "Suwannaphum", "Swanky and Moo Moo", "Syncopate", "Syne", "Syne Mono", "Syne Tactile", "Tajawal", "Tangerine", "Taprom", "Tauri", "Taviraj", "Teko", "Telex", "Tenali Ramakrishna", "Tenor Sans", "Text Me One", "Texturina", "Thasadith", "The Girl Next Door", "Tienne", "Tillana", "Timmana", "Tinos", "Titan One", "Titillium Web", "Tomorrow", "Trade Winds", "Trirong", "Trispace", "Trocchi", "Trochut", "Trykker", "Tulpen One", "Turret Road", "Ubuntu", "Ubuntu Condensed", "Ubuntu Mono", "Ultra", "Uncial Antiqua", "Underdog", "Unica One", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "Unna", "Vampiro One", "Varela", "Varela Round", "Varta", "Vast Shadow", "Vesper Libre", "Viaoda Libre", "Vibes", "Vibur", "Vidaloka", "Viga", "Voces", "Volkhov", "Vollkorn", "Vollkorn SC", "Voltaire", "VT323", "Waiting for the Sunrise", "Wallpoet", "Walter Turncoat", "Warnes", "Wellfleet", "Wendy One", "Wire One", "Work Sans", "Xanh Mono", "Yanone Kaffeesatz", "Yantramanav", "Yatra One", "Yellowtail", "Yeon Sung", "Yeseva One", "Yesteryear", "Yrsa", "Yusei Magic", "ZCOOL KuaiLe", "ZCOOL QingKe HuangYou", "ZCOOL XiaoWei", "Zeyada", "Zhi Mang Xing", "Zilla Slab", "Zilla Slab Highlight"];
                                        var rureraform_localfonts = ["Arial", "Bookman", "Century Gothic", "Comic Sans MS", "Courier", "Garamond", "Georgia", "Helvetica", "Lucida Grande", "Palatino", "Tahoma", "Times", "Trebuchet MS", "Verdana"];
                                        var rureraform_customfonts = [];
                                                @php echo 'var rureraform_toolbar_tools = '.json_encode($toolbar_tools); @endphp;
                                                @php echo 'var rureraform_meta = '.json_encode($element_properties_meta); @endphp;
                                                var rureraform_validators = [];
                                        var rureraform_filters = [];
                                        var rureraform_confirmations = [];
                                        var rureraform_notifications = [];
                                        var rureraform_integrations = [];
                                        var rureraform_payment_gateway = [];
                                        var rureraform_math_expressions_meta = [];
                                        var rureraform_logic_rules = [];
                                        var rureraform_predefined_options = [];
                                                @php echo 'var rureraform_form_options = '.$tabs_options; @endphp;
                                                var rureraform_form_pages_raw = [{"general": "general", "name": "Page", "id": 1, "type": "page"}];
                                        //var rureraform_form_elements_raw = []; //Default Value for Questions
                                        @php echo 'var rureraform_form_elements_raw = '.json_encode($layout_elements); @endphp;
                                                //var rureraform_form_elements_raw = ["{\"type\":\"image_quiz\",\"resize\":\"both\",\"height\":\"auto\",\"_parent\":\"1\",\"_parent-col\":\"0\",\"_seq\":0,\"id\":2,\"basic\":\"basic\",\"content\":\"    test     \",\"elements_data\":\"W3siMjM3OCI6eyJmaWVsZF90eXBlIjoiaW1hZ2UiLCJpbWFnZSI6Ii9zdG9yZS8xL2Rhc2hib2FyZC5wbmcifSwiNDAwNjEiOnsiZmllbGRfdHlwZSI6ImltYWdlIiwiaW1hZ2UiOiIvc3RvcmUvMS9kYXNoYm9hcmQucG5nIn19XQ==\"}"];
                                                //var rureraform_form_elements_raw = ["{\"basic\":\"basic\",\"content\":\&lt;span class=&quot;block-holder&quot;&gt;&lt;img data-field_type=&quot;image&quot; data-id=&quot;2378&quot; id=&quot;field-2378&quot; class=&quot;editor-field&quot; src=&quot;\/store\/1\/dashboard.png&quot; heigh=&quot;50&quot; width=&quot;50&quot; data-image=&quot;\/store\/1\/dashboard.png&quot;&gt;&lt;\/span&gt;&amp;nbsp; &amp;nbsp; test&amp;nbsp; &amp;nbsp;&amp;nbsp;&lt;span class=&quot;block-holder&quot;&gt;&lt;img data-field_type=&quot;image&quot; data-id=&quot;40061&quot; id=&quot;field-40061&quot; class=&quot;editor-field&quot; src=&quot;\/store\/1\/default_images\/admin_dashboard.jpg&quot; heigh=&quot;50&quot; width=&quot;50&quot; data-image=&quot;\/store\/1\/default_images\/admin_dashboard.jpg&quot;&gt;&lt;\/span&gt;&amp;nbsp;&lt;br&gt;",\"elements_data\":{\"2378\":{\"data-field_type\":\"image\",\"data-id\":\"2378\",\"id\":\"field-2378\",\"class\":\"editor-field\",\"src\":\"\/store\/1\/dashboard.png\",\"heigh\":\"50\",\"width\":\"50\",\"data-image\":\"\/store\/1\/dashboard.png\"},\"40061\":{\"data-field_type\":\"image\",\"data-id\":\"40061\",\"id\":\"field-40061\",\"class\":\"editor-field\",\"src\":\"\/store\/1\/default_images\/admin_dashboard.jpg\",\"heigh\":\"50\",\"width\":\"50\",\"data-image\":\"\/store\/1\/default_images\/admin_dashboard.jpg\"}},\"type\":\"image_quiz\",\"resize\":\"both\",\"height\":\"auto\",\"_parent\":\"1\",\"_parent-col\":\"0\",\"_seq\":0,\"id\":2}"];
                                                var rureraform_integration_providers = [];
                                        var rureraform_payment_providers = [];
                                        var rureraform_styles = [{"id": "native-35", "name": "Beige Beige", "type": 1}, {"id": "native-31", "name": "Black and White", "type": 1}, {"id": "native-30", "name": "Blue Lagoon", "type": 1}, {"id": "native-45", "name": "Chamomile Tea", "type": 1}, {"id": "native-32", "name": "Classic Green", "type": 1}, {"id": "native-34", "name": "Dark Night", "type": 1}, {"id": "native-29", "name": "Deep Space", "type": 1}, {"id": "native-27", "name": "Default Style", "type": 1}, {"id": "native-42", "name": "Greenery", "type": 1}, {"id": "native-43", "name": "Honey Bee", "type": 1}, {"id": "native-44", "name": "Honeysuckle", "type": 1}, {"id": "native-47", "name": "Lava Rocks", "type": 1}, {"id": "native-33", "name": "Light Blue", "type": 1}, {"id": "native-40", "name": "Living Coral", "type": 1}, {"id": "native-36", "name": "Mariana Trench", "type": 1}, {"id": "native-37", "name": "Peach Button", "type": 1}, {"id": "native-46", "name": "Something Blue", "type": 1}, {"id": "native-41", "name": "Ultra Violet", "type": 1}];
                                        jQuery(document).ready(function () {
                                            rureraform_form_ready();
                                        });
                                        console.log(rureraform_form_elements_raw);
                                    </script>
                                </div>				</div>
                        </div>

                    </div>
                </div>































                <div class="fields-layout-options">
                    
                    
                    <div class='text232-field-options'>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="score" value="0" placeholder="Score" data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="placeholder" placeholder="Placeholder" data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="size" value="1" placeholder="Size" data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><select class="element-field" data-field_type="field_size" data-field_id="field_dynamic_id">
                                <option value="field_extra_small">Extra Small</option>
                                <option value="field_small" selected="selected">Small</option>
                                <option value="field_medium">Medium</option>
                                <option value="field_large">Large</option>
                            </select>
                        </div>
                        <i class="fas fa-plus repeater-class" data-field_id="field_dynamic_id" data-field_type="text"></i>
                        <label>Correct Answere</label>
                        <div class="repeater-fields">
                            <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="correct_answere" placeholder="Correct Answere" data-field_id="field_dynamic_id"><i class="fas fa-trash-alt remove-repeater-field"></i></div>
                        </div>
                    </div>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    <div class='text-field-options'>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="score" value="0" placeholder="Score" data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="placeholder" placeholder="Placeholder" data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="size" value="1" placeholder="Size" data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><select class="element-field" data-field_type="field_size" data-field_id="field_dynamic_id">
                                <option value="field_extra_small">Extra Small</option>
                                <option value="field_small" selected="selected">Small</option>
                                <option value="field_medium">Medium</option>
                                <option value="field_large">Large</option>
                            </select>
                        </div>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="correct_answere" placeholder="Correct Answer" data-field_id="field_dynamic_id"></div>
                    </div>

                    <div class='select-field-options'>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="score" placeholder="Score" data-field_id="field_dynamic_id"></div>
                        <i class="fas fa-plus repeater-class" data-field_id="field_dynamic_id" data-field_type="select"></i>
                        <label>Options</label>	
                        <div class="repeater-fields">
                            <div class='quiz-form-control'>
                                <input type='radio' class="select-correct-element-field" id="correct-field_dynamic_id-option_dynamic_id" name="correct-field_dynamic_id" data-field_type="option_correct" placeholder="Correct Answere" data-field_id="field_dynamic_id">
                                <input type='text' class="element-field" data-field_type="select_option" placeholder="Select Option" data-field_id="field_dynamic_id" data-field_option_id="correct-field_dynamic_id-option_dynamic_id"><i class="fas fa-trash-alt remove-repeater-field"></i></div>
                        </div>
                    </div>   
                    
                    
                    <div class='radio-field-options'>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="score" placeholder="Score" data-field_id="field_dynamic_id"></div>
                        <i class="fas fa-plus repeater-class" data-field_id="field_dynamic_id" data-field_type="radio"></i>
                        <label>Options</label>	
                        <div class="repeater-fields">
                            <div class='quiz-form-control'>
                                <input type='radio' class="select-correct-element-field" id="correct-field_dynamic_id-option_dynamic_id" name="correct-field_dynamic_id" data-field_type="radio_correct" placeholder="Correct Answere" data-field_id="field_dynamic_id">
                                <input type='text' class="element-field" data-field_type="radio_option" placeholder="Select Option" data-field_id="field_dynamic_id" data-field_option_id="correct-field_dynamic_id-option_dynamic_id"><i class="fas fa-trash-alt remove-repeater-field"></i></div>
                        </div>
                    </div>  
                    
                    <div class='checkbox-field-options'>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="score" placeholder="Score" data-field_id="field_dynamic_id"></div>
                        <i class="fas fa-plus repeater-class" data-field_id="field_dynamic_id" data-field_type="checkbox"></i>
                        <label>Options</label>	
                        <div class="repeater-fields">
                            <div class='quiz-form-control'>
                                <input type='checkbox' class="select-correct-element-field" id="correct-field_dynamic_id-option_dynamic_id" name="correct-field_dynamic_id" data-field_type="checkbox_correct" placeholder="Correct Answere" data-field_id="field_dynamic_id">
                                <input type='text' class="element-field" data-field_type="checkbox_option" placeholder="Select Option" data-field_id="field_dynamic_id" data-field_option_id="correct-field_dynamic_id-option_dynamic_id"><i class="fas fa-trash-alt remove-repeater-field"></i></div>
                        </div>
                    </div>  



                    <div class='paragraph-field-options'>
                        <div class='quiz-form-control'>
                            <select class="element-field" data-field_type="font_heading" data-field_id="field_dynamic_id">
                                <option value="" selected="selected">Heading</option>
                                <option value="h1">H1</option>
                                <option value="h2">H2</option>
                                <option value="h3">H3</option>
                                <option value="h4">H4</option>
                                <option value="h5">H5</option>
                                <option value="h6">H6</option>
                            </select>
                        </div>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="font_size" placeholder="Font Size" data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="font_color" placeholder="Color" data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="link" placeholder="Link" data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><select class="element-field" data-field_type="font_align" data-field_id="field_dynamic_id">
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                                <option value="right">Right</option>
                            </select>
                        </div>

                        <div class='quiz-form-control'>
                            Bold <input type="checkbox" data-value="bold" class="element-field" data-field_type="font_styles" data-field_id="field_dynamic_id">&nbsp;&nbsp;&nbsp;
                            Italic <input type="checkbox" data-value="italic" class="element-field" data-field_type="font_styles" data-field_id="field_dynamic_id">&nbsp;&nbsp;&nbsp;
                            Underline <input type="checkbox" data-value="underline" class="element-field" data-field_type="font_styles" data-field_id="field_dynamic_id">&nbsp;&nbsp;&nbsp;
                            Line through<input type="checkbox" data-value="line-through" class="element-field" data-field_type="font_styles" data-field_id="field_dynamic_id">
                        </div>
                    </div>



                    <div class='image-field-options'>


                        <div class="quiz-form-control form-group mt-15">
                            <label class="input-label">Image</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="input-group-text admin-file-manager" data-input="image_field_dynamic_id" data-preview="holder">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </div>
                                <input type="text" name="image_cover" id="image_field_dynamic_id" value="" data-field_type="image" data-field_id="field_dynamic_id" class="element-field form-control"/>
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text admin-file-view" data-input="image_field_dynamic_id">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="height" placeholder="Height" data-field_id="field_dynamic_id"></div>
                        <div class='quiz-form-control'><input type='text' class="element-field" data-field_type="width" placeholder="Width" data-field_id="field_dynamic_id"></div>
                    </div>

                </div>





                <div class="mt-5 mb-5">
                    <button type="button" class="quiz-stage-generate btn btn-primary">{{ !empty($quiz) ? trans('admin/main.save_change') : trans('admin/main.create') }}</button>
                    <button type="submit" class="submit-btn-quiz-create btn btn-primary hide">{{ !empty($quiz) ? trans('admin/main.save_change') : trans('admin/main.create') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
<script>
                                        var saveSuccessLang = '{{ trans('webinars.success_store') }}';</script>


<script src="/assets/default/js/admin/quiz.min.js"></script>

@endpush
