<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Product;
use App\Models\Headquater;
use App\Http\Requests\CreateValidationRequest;
class CarsController extends Controller
{
    public function __construct(){
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //converting object to array
        //$cars = Car::all()->toArray();

        //var_dump($cars);

        //converting object to Json
        // $cars = Car::all()->toJson();
        // $cars = json_decode($cars);

        //var_dump($cars);


        //Query builder Pagination
        //$car = DB::table('cars')->paginate(4);

        $cars = Car::paginate(2);

        return view('cars.index', [
            'cars' => $cars
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //public function store(CreateValidationRequest $request)
    public function store(Request $request)
    {
        // $car = new Car;
        // $car->name = $request->input('name');
        // $car->founded = $request->input('founded');
        // $car->description = $request->input('description');
        // $car->save();

        //passing data in an array to an model by using create method
        //We also need to use fillable property in Cars Model


        
        //---- START Different Types of request method---//
        //Request all input field
        //$test = $request->all();

        //Except Method
        //$test = $request->except('_token');

        //Except Method with two arguement
        //$test = $request->except(['_token', 'name']);

        //Inverse of Except is only
        //$test = $request->only(['_token', 'name']);


        //Has method
        //$test = $request->has('founded');

        // if($request->has('founded')){
        //     dd('Founded has been found');
        // }

        //Current path - is it used to verity our incoming request
        //dd($request->path());
            
        // if($request->is('cars')){
        //     dd('End point is car');
        // }

        //Checkin the method request
        // if($request->method('post')){
        //     dd('Our method is post');
        // }

        //Show the URL
        //dd($request->url());

        //Show the ip address
        //dd($request->ip());

        //---- END Different Types of request method---//

        //Validation 
        // $request->validate([
        //     'name' => 'required:unique:cars',
        //     'founded' => 'required|integer|min:0|max:2021',
        //     'description' => 'required'
        // ]);

        //Validation after making CreateValidationRequest
        //$request->validate();

        //Methods we can use on $request for file
        //guessExtension()
        //getMimeType()
        //store()
        //asStore()
        //storePublicly()
        //move()
        //getClientOriginalName()
        //getClientMimeType()
        //guessClientExtension()
        //getSize()
        //getError()

        //dd($request->file('image')->isValid());



        $request->validate([
            'image' => 'required|mimes:png,jpg,jpeg|max:5048',
            'name' => 'required:unique:cars',
            'founded' => 'required|integer|min:0|max:2021',
            'description' => 'required'
        ]);
        
        //Naming the image file (time + nameOfCar + imageExtension)
        $newImageName = time(). '-' . $request->name . '.' . $request->image->extension();

        //Moving image to the public\images folder
        $request->image->move(public_path('images'), $newImageName);


        //If its valid it will proceed
        //It it's not valid, throw a new ValidationException
        $car = Car::create([
            'name' => $request->input('name'),
            'founded' => $request->input('founded'),
            'description' => $request->input('description'),
            'image_path' => $newImageName,
            'user_id' => auth()->user()->id
        ]);

        return redirect('/cars')->with('msg','A new car has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::findOrFail($id);

        // $hq = Headquater::find($id);

        // var_dump($hq);

        //dd($car->engines);

        //var_dump($car->productionDate);

        $product = Product::find($id);

        print_r($product);

        return view('cars.show')->with('car', $car);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = Car::findOrFail($id); 

        return view('cars.edit')->with('car', $car);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, $id)
    public function update(CreateValidationRequest $request, $id)
    {   
        $request->validate();

        $car = Car::where('id', $id)
            ->update([
            'name' => $request->input('name'),
            'founded' => $request->input('founded'),
            'description' => $request->input('description'),
        ]);

        return redirect('/cars')->with('msg','Car details has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect('/cars')->with('msg','Car has been deleted!');
    }
}





// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Car;
// use App\Models\Product;
// use App\Models\Headquater;
// class CarsController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function index()
//     {
//         //converting object to array
//         //$cars = Car::all()->toArray();

//         //var_dump($cars);

//         //converting object to Json
//         // $cars = Car::all()->toJson();
//         // $cars = json_decode($cars);

//         //var_dump($cars);


//         //Query builder Pagination
//         //$car = DB::table('cars')->paginate(4);

//         $cars = Car::paginate(2);

//         return view('cars.index', [
//             'cars' => $cars
//         ]);

//     }

//     /**
//      * Show the form for creating a new resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function create()
//     {
//         return view('cars.create');
//     }

//     /**
//      * Store a newly created resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function store(Request $request)
//     {
//         // $car = new Car;
//         // $car->name = $request->input('name');
//         // $car->founded = $request->input('founded');
//         // $car->description = $request->input('description');
//         // $car->save();

//         //passing data in an array to an model by using create method
//         //We also need to use fillable property in Cars Model
//         $car = Car::create([
//             'name' => $request->input('name'),
//             'founded' => $request->input('founded'),
//             'description' => $request->input('description'),
//         ]);

//         return redirect('/cars')->with('msg','A new car has been added');
//     }

//     /**
//      * Display the specified resource.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function show($id)
//     {
//         $car = Car::findOrFail($id);

//         // $hq = Headquater::find($id);

//         // var_dump($hq);

//         //dd($car->engines);

//         //var_dump($car->productionDate);

//         $product = Product::find($id);

//         print_r($product);

//         return view('cars.show')->with('car', $car);
//     }

//     /**
//      * Show the form for editing the specified resource.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function edit($id)
//     {
//         $car = Car::findOrFail($id); 

//         return view('cars.edit')->with('car', $car);
//     }

//     /**
//      * Update the specified resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function update(Request $request, $id)
//     {
//         $car = Car::where('id', $id)
//             ->update([
//             'name' => $request->input('name'),
//             'founded' => $request->input('founded'),
//             'description' => $request->input('description'),
//         ]);

//         return redirect('/cars')->with('msg','Car details has been updated!');
//     }

//     /**
//      * Remove the specified resource from storage.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function destroy(Car $car)
//     {
//         $car->delete();
//         return redirect('/cars')->with('msg','Car has been deleted!');
//     }
// }


// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Car;

// class CarsController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function index()
//     {
//         //select * from cars
//         $cars = Car::all();
//         return view('cars.index', [
//             'cars' => $cars
//         ]);

//     }

//     /**
//      * Show the form for creating a new resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function create()
//     {
//         return view('cars.create');
//     }

//     /**
//      * Store a newly created resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function store(Request $request)
//     {
//         // $car = new Car;
//         // $car->name = $request->input('name');
//         // $car->founded = $request->input('founded');
//         // $car->description = $request->input('description');
//         // $car->save();

//         //passing array to an model
//         $car = Car::create([
//             'name' => $request->input('name'),
//             'founded' => $request->input('founded'),
//             'description' => $request->input('description'),
//         ]);

//         return redirect('/cars')->with('msg','A new car has been added');
//     }

//     /**
//      * Display the specified resource.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function show($id)
//     {
//         //
//     }

//     /**
//      * Show the form for editing the specified resource.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function edit($id)
//     {
//         $car = Car::findOrFail($id); 

//         return view('cars.edit')->with('car', $car);
//     }

//     /**
//      * Update the specified resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function update(Request $request, $id)
//     {
//         $car = Car::where('id', $id)
//             ->update([
//             'name' => $request->input('name'),
//             'founded' => $request->input('founded'),
//             'description' => $request->input('description'),
//         ]);

//         return redirect('/cars')->with('msg','Car details has been updated!');
//     }

//     /**
//      * Remove the specified resource from storage.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function destroy(Car $car)
//     {
//         $car->delete();
//         return redirect('/cars')->with('msg','Car has been deleted!');
//     }
// }
