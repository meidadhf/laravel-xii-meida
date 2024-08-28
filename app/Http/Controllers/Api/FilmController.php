<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Http\Requests\Api\{
        StoreFilmRequest,
        UpdateFilmRequest,
    };
    use App\Interfaces\FilmRepositoryInterface;
    use App\Repositories\FilmRepository;
    use App\Classes\ApiResponseClass;
    use App\Http\Resources\FilmResource;
    use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    private FilmRepositoryInterface $filmRepositoryInterface;

    public function __construct(FilmRepositoryInterface $filmRepositoryInterface)
    {
        $this->filmRepositoryInterface = $filmRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = $this->filmRepositoryInterface->index();
        return ApiResponseClass::sendResponse(FilmResource::collection($details),'', 200);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFilmRequest $request)
    {
        //
        $posterPath = $request->file('poster')->store('storage/app/public/images');

        $details = [
            'title'     => $request->title,
            'sinopsis'  => $request->sinopsis,
            'year'      => $request->year,
            'poster'    => $posterPath,
            'genre_id'  => $request->genre_id,
        ];

        DB::beginTransaction();
        try{
             $film = $this->filmRepositoryInterface->store($details);

             DB::commit();
             return ApiResponseClass::sendResponse(new FilmResource($film),'Film Create Successful',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $Film =$this->filmRepositoryInterface->getById(id: $id);

        return ApiResponseClass::sendResponse(result: new FilmResource(resource: $Film), message: '', code: 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $posterPath = $request->file('poster')->store('storage/app/public/images');

        $UpdateDetails = [
            'title'     => $request->title,
            'sinopsis'  => $request->sinopsis,
            'year'      => $request->year,
            'poster'    => $posterPath,
            'genre_id'  => $request->genre_id,
        ];
        DB::beginTransaction();
        try{
            $film = $this->filmRepositoryInterface->update($UpdateDetails, $id);
            DB::commit();
            return ApiResponseClass::sendResponse('Film Update Successful', 201);
        } catch(\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $this->filmRepositoryInterface->delete($id);
        return ApiResponseClass::sendResponse('Film Delete Successful', 204);
    }
}
