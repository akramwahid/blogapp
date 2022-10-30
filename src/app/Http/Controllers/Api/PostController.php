<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Blog\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return new PostCollection(
            Post::when($request->filled('searchAuthor'), function ($query) use($request){
                return $query->whereHas('author', function ($sql) use($request){
                    $sql->where('name', 'like', '%'.$request->input('searchAuthor').'%');
                });
            })->orderBy('created_at', 'DESC')->paginate(20)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->validated());
        return new PostResource($post);
    }

    /**
     * Store a image upload in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function upload(Request $request)
    {
        $rules = [
            'fileupload-picture' => 'required|image|mimes:jpg,jpeg,png,gif|max:1000',
        ];

        $messages = [
            'fileupload-picture.required' => 'You must upload a file.',
            'fileupload-picture.image' => 'Uploaded file must be an Image file.',
            'fileupload-picture.mimes' => 'Uploaded file must be a type of JPG,PNG or GIF files',
            'fileupload-picture.max' => 'Uploaded File should be less than 1 MB in size !'
        ];

        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
            $response = ["Status" => "Fail",'Message' => $validator->messages()->toArray()["fileupload-picture"][0]];
            return response()->json($response);
        }


        if($request->file('fileupload-picture')->isValid()){
            try{
                $fileName = Uuid::uuid4()->toString().'.jpg';
                $request->file('fileupload-picture')->storeAs('posts', $fileName, 'public');

                $response = [
                    "Name" => $fileName,
                    "Type" => $request->file('fileupload-picture')->getClientMimeType(),
                    "OriginalFileName" => $request->file('fileupload-picture')->getClientOriginalName(),
                    "UrlPath" => '/storage/posts/'.$fileName
                ];

                return response()->json($response);
            }catch (\Exception $ex){
                $response = [
                    "Status" => "Fail",
                    "Message" => $ex->getMessage()
                ];

                return response()->json($response);
            }
        }else{
            $response = [
                "Status" => "Fail",
                "Message" => "Please Upload a valid Image File!."
            ];
            return response()->json($response);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->noContent();
    }
}
