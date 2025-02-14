<?php
require_once __DIR__ . '/../lib/common.php';

$book_id = $_GET['id'] ?? 0;
$book = [];
$ratings = [];
$ol_id = '';
$errors = [];
$id_goodreads = '';

if (!empty($book_id)) {

    $res = get_book_by_id($book_id);

    if (!empty($res)) {
        $book = $res[0];
    } else {
        $errors['book_not_found'] = "Cartea nu a fost gasita.";
    }
} else {
    $errors['book_id'] = "ID-ul cartii nu este valid.";
}

//book ratings parser from Goodreads by using Open Library API
if (!empty($book)) {
    // get Goodreads id book by using Open Library API
    $base_url = "https://openlibrary.org/search.json";
    // book identifier, e.g. isbn
    $isbn = str_replace('-', '', $book['isbn']);

    $query_url = $base_url . "?isbn=" . $isbn;

    $response = fetchFullHtml($query_url); // => json

    if ($response === false) {
        $errors['parser_open_library'] = "Nu s-a putut accesa API-ul Open Library.";
    } else {
        $data = json_decode($response, true); // => array

        if (isset($data['docs']) && !empty($data['docs'])) {

            $book_ol = $data['docs'][0];

            $ol_id = $book_ol['cover_edition_key'] ?? $book_ol['edition_key'][0];

            $id_goodreads = $data['docs'][0]['id_goodreads'][0];
            // $ratings = [
            //     "ratings_average" => $book_ol['ratings_average'] ?? 0,
            //     "ratings_count" => $book_ol['ratings_count'] ?? '',
            // ];

            // get rating data from Goodreads
            if (!empty($id_goodreads)) {
                $search_url = 'https://www.goodreads.com/book/show/' . $id_goodreads;
                $html = fetchFullHtml($search_url);

                if ($html === false) {
                    $errors['parser_goodreads'] = "Nu s-a putut accesa pagina de cautare.";
                }

                // get rating
                $rating_start = strpos($html,  'class="RatingStatistics__rating"');
                $rating_fragment = substr($html, $rating_start, 100);
                $parts = explode('>', $rating_fragment); // Împarte pe baza ">"
                $rating = trim(strip_tags($parts[1]));

                // get reviews count
                $review_count_start = strpos($html, 'data-testid="reviewsCount"');
                if ($review_count_start !== false) {
                    $review_count_fragment = substr($html, $review_count_start, 100);
                    $parts = explode('>', $review_count_fragment);
                    $review_count = trim(strip_tags($parts[1]));
                }

                if (!empty($rating)) {
                    $ratings = [
                        'ratings_average' => $rating,
                        'review_count' => $review_count,
                    ];
                }
            }
        }
    }
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
}


/*
{
    "numFound": 1,
    "start": 0,
    "numFoundExact": true,
    "docs": [
        {
            "author_key": [
                "OL219707A"
            ],
            "author_name": [
                "Nathaniel Branden"
            ],
            "cover_edition_key": "OL7823586M",
            "cover_i": 368810,
            "ddc": [
                "158.1"
            ],
            "ebook_access": "printdisabled",
            "ebook_count_i": 3,
            "edition_count": 5,
            "edition_key": [
                "OL7822305M",
                "OL3175609M",
                "OL23044484M",
                "OL7823586M",
                "OL22455772M"
            ],
            "first_publish_year": 1983,
            "first_sentence": [
                "\"The greatest evil that can befall man is that he should come to think ill of himself,\" wrote Goethe."
            ],
            "format": [
                "Mass Market Paperback"
            ],
            "has_fulltext": true,
            "ia": [
                "honoringselfself00bran",
                "honoringselfpsyc00bran",
                "honoringselfpers0000bran"
            ],
            "ia_collection": [
                "americana",
                "internetarchivebooks",
                "openlibrary-d-ol",
                "printdisabled"
            ],
            "ia_collection_s": "americana;internetarchivebooks;openlibrary-d-ol;printdisabled",
            "isbn": [
                "0874772702",
                "9780553251197",
                "8475095852",
                "9788475095851",
                "0553268147",
                "9780553268140",
                "0553251198",
                "9780874772708"
            ],
            "key": "/works/OL1835074W",
            "language": [
                "spa",
                "eng"
            ],
            "last_modified_i": 1735248262,
            "lcc": [
                "BF-0697.00000000.B687 1983",
                "BF-0697.00000000.B687 2004",
                "BF-0697.00000000.B68 1985"
            ],
            "lccn": [
                "83018001"
            ],
            "number_of_pages_median": 268,
            "oclc": [
                "10072695",
                "39527499"
            ],
            "printdisabled_s": "OL7823586M;OL22455772M",
            "public_scan_b": false,
            "publish_date": [
                "1985",
                "1983",
                "August 1, 1985",
                "1990"
            ],
            "publish_place": [
                "Los Angeles",
                "Toronto",
                "Boston",
                "Barcelona"
            ],
            "publish_year": [
                1985,
                1990,
                1983
            ],
            "publisher": [
                "Paid\u00f3s",
                "Bantam",
                "Bantam Books",
                "Distributed by Houghton Mifflin Co.",
                "J.P. Tarcher"
            ],
            "seed": [
                "/books/OL7822305M",
                "/books/OL3175609M",
                "/books/OL23044484M",
                "/books/OL7823586M",
                "/books/OL22455772M",
                "/works/OL1835074W",
                "/authors/OL219707A",
                "/subjects/autoestima",
                "/subjects/autonomy_(psychology)",
                "/subjects/autonom\u00eda_(psicolog\u00eda)",
                "/subjects/egoism",
                "/subjects/ego\u00edsmo",
                "/subjects/psychological_aspects",
                "/subjects/psychological_aspects_of_self-confidence",
                "/subjects/psychological_aspects_of_self-esteem",
                "/subjects/self-confidence",
                "/subjects/self-esteem",
                "/subjects/conduct_of_life",
                "/subjects/autonomy",
                "/subjects/self_concept"
            ],
            "title": "Honoring the self",
            "title_sort": "Honoring the self",
            "title_suggest": "Honoring the self",
            "type": "work",
            "id_librarything": [
                "483461",
                "483461",
                "483461",
                "483461"
            ],
            "id_goodreads": [
                "2849586",
                "220622",
                "646185"
            ],
            "subject": [
                "Autoestima",
                "Autonomy (Psychology)",
                "Autonom\u00eda (Psicolog\u00eda)",
                "Egoism",
                "Ego\u00edsmo",
                "Psychological aspects",
                "Psychological aspects of Self-confidence",
                "Psychological aspects of Self-esteem",
                "Self-confidence",
                "Self-esteem",
                "Conduct of life",
                "Autonomy",
                "Self Concept"
            ],
            "ia_box_id": [
                "IA109214",
                "IA122312"
            ],
            "ratings_average": 4.0,
            "ratings_sortable": 2.3286738,
            "ratings_count": 1,
            "ratings_count_1": 0,
            "ratings_count_2": 0,
            "ratings_count_3": 0,
            "ratings_count_4": 1,
            "ratings_count_5": 0,
            "readinglog_count": 27,
            "want_to_read_count": 24,
            "currently_reading_count": 1,
            "already_read_count": 2,
            "publisher_facet": [
                "Bantam",
                "Bantam Books",
                "Distributed by Houghton Mifflin Co.",
                "J.P. Tarcher",
                "Paid\u00f3s"
            ],
            "subject_facet": [
                "Autoestima",
                "Autonomy",
                "Autonomy (Psychology)",
                "Autonom\u00eda (Psicolog\u00eda)",
                "Conduct of life",
                "Egoism",
                "Ego\u00edsmo",
                "Psychological aspects",
                "Psychological aspects of Self-confidence",
                "Psychological aspects of Self-esteem",
                "Self Concept",
                "Self-confidence",
                "Self-esteem"
            ],
            "_version_": 1819539685072961536,
            "lcc_sort": "BF-0697.00000000.B687 1983",
            "author_facet": [
                "OL219707A Nathaniel Branden"
            ],
            "subject_key": [
                "autoestima",
                "autonomy",
                "autonomy_(psychology)",
                "autonom\u00eda_(psicolog\u00eda)",
                "conduct_of_life",
                "egoism",
                "ego\u00edsmo",
                "psychological_aspects",
                "psychological_aspects_of_self-confidence",
                "psychological_aspects_of_self-esteem",
                "self-confidence",
                "self-esteem",
                "self_concept"
            ],
            "ddc_sort": "158.1"
        }
    ],
    "num_found": 1,
    "q": "",
    "offset": null
} 
*/