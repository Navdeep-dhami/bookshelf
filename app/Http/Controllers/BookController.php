<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookFormRequest;
use App\Models\Book;
use Inertia\Inertia;
use App\Models\Genre;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        // $users->appends(['sort' => 'votes']);
        //   $users = User::paginate(15);
        // User::paginate(15)->withQueryString();

        $builder = Book::with(
            [
                'author:id,name',
                'genre:id,name',
                'publisher:id,name'
            ]
            );

        if(!empty($input['query']))
        {
            switch($input['category'])
            {
                case 'title':
                    $builder->where('title','like',"%".$input['query']."%");
                    break;

                case 'isbn':
                    $builder->where('isbn',$input['query']);
                    break;

                case 'genre':
                    $genres = Genre::where('name','like',"%".$input['query']."%")->pluck('id')->toArray();
                    $builder->whereIn('genre_id',$genres);
                    break;

                case 'author':
                    $authors = Author::where('name','like',"%".$input['query']."%")->pluck("id")->toArray();
                    $builder->whereIn('author_id',$authors);
                    break;

                case 'publication':
                    $builder->where('published',$input['query']);
                    break;

                default:
                    # nothing to code...
                    break;
            }
        }
        $books = $builder->paginate(15);
        return response()->json($books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $book = new Book();
        return Inertia::render('BookForm',[
            'book' => $book
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookFormRequest $request)
    {
        dd('validation test');
        $imagePath = $request->image;
        $book = new Book();
        $book->title = $request->title;
        $book->description = $request->description;
        $book->isbn = $request->isbn;
        $book->image = $imagePath;
        $book->published = $request->published;
        $book->author_id = Author::firstOrCreate(['name' => $request->author])->id;
        $book->genre_id = Genre::firstOrCreate(['name' => $request->genre])->id;
        $book->publisher_id = Publisher::firstOrCreate(['name' => $request->publisher])->id;
        $book->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::with(["author:id,name","publisher:id,name","genre:id,name"])->find($id);
        return Inertia::render('BookForm',[
            'book' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookFormRequest $request,Book $book)
    {
        dd("validation test");
        $imagePath = $request->image;
        $book->title = $request->title;
        $book->description = $request->description;
        $book->isbn = $request->isbn;
        $book->image = $imagePath;
        $book->published = $request->published;
        $book->author_id = Author::firstOrCreate(['name' => $request->author])->id;
        $book->genre_id = Genre::firstOrCreate(['name' => $request->genre])->id;
        $book->publisher_id = Publisher::firstOrCreate(['name' => $request->publisher])->id;
        $book->save();

        return Redirect::route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Book $book)
    {
        //
        $book->delete();
        // return print_r($request->all());
    }

    public function fetchData()
    {
    ini_set('max_execution_time',1800);
    if(Book::count() > 100)
    {
        return "All Set";
    }
    $url = "https://fakerapi.it/api/v1/books?_quantity=200";
    $json = json_decode(file_get_contents($url));
    $records = ($json->code == 200)? $json->data : [];
    foreach($records as $record)
    {
        $book = Book::firstOrNew(['isbn' => $record->isbn]);
        $book->title = $record->title;
        $book->description = $record->description;
        $book->isbn = $record->isbn;
        $book->image = $record->image;
        $book->published = $record->published;
        $book->author_id = Author::firstOrCreate(['name' => $record->author])->id;
        $book->genre_id = Genre::firstOrCreate(['name' => $record->genre])->id;
        $book->publisher_id = Publisher::firstOrCreate(['name' => $record->publisher])->id;
        $book->save();
    }
    return 'done';
    }
}
