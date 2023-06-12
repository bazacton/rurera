<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Books;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class BooksController extends Controller
{
    public function book($book_slug)
    {

        $bookObj = Books::where('book_slug' , $book_slug)->with(['bookFinalQuiz.QuestionData' , 'bookPages.PageInfoLinks'])->first();

        $page_content = array();
        $info_type = array();
        if (!empty($bookObj->bookPages)) {
            foreach ($bookObj->bookPages as $page_data) {
                $info_link_html = '';
                if (!empty($page_data->PageInfoLinks)) {
                    foreach ($page_data->PageInfoLinks as $pageInfoLinks) {
                        $data_values = isset($pageInfoLinks['data_values']) ? json_decode($pageInfoLinks['data_values']) : array();
                        $info_link_html .= '<div class="info_link_div info_link_' . $pageInfoLinks['info_type'] . '" style="width: max-content;position:absolute;' . $pageInfoLinks['info_style'] . '">';
                        switch ($pageInfoLinks['info_type']) {
                            case "text":
                                $info_link_html .= '<span style="' . $data_values->text_color . '">';
                                $info_link_html .= isset($data_values->text_html) ? $data_values->text_html : '';
                                $info_link_html .= '</span>';
                                break;

                            case "highlighter":
                                $info_link_html .= '<span style="position: absolute;opacity: 0.7;' . $data_values->highlighter_size . '; ' . $data_values->highlighter_background . '">';
                                $info_link_html .= '</span>';
                                break;

                            case "check_it_makes_sense":
                                $info_link_html .= '<img src="/assets/default/img/book-icons/infobox.png" style="width: 42px;height: auto;">';
                                break;
                        }

                        $info_link_html .= '</div>';
                    }
                }
                $page_content[$page_data->id] = $info_link_html;
            }
        }
        //pre('test');

        if (!empty($bookObj)) {
            $data = [
                'pageTitle'    => $bookObj->book_title ,
                'book'         => $bookObj ,
                'page_content' => $page_content ,
            ];
            return view('web.default.pages.book' , $data);
        }

        abort(404);
    }
}
