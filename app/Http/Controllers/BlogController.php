<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\models\Blog;
use App\Http\Controllers\Controller as Controller;

class BlogController extends Controller
{
    public function index(){
                //Get list of blogs
                $blogs = Blog::all();
                $message = 'Blogs retrieved successfully.';
                $status = true;

                //Call function for response data
                $response = $this->response($status, $blogs, $message);
                return $response;
            }

    public function store(Request $request){
                //Get request data
                $input = $request->all();
        
                //Validate requested data
                $validator = Validator::make($input, [
                    'name' => 'required',
                    'description' => 'required'
                ]);
                if ($validator->fails()) {
                    return $this->sendError('Validation Error.', $validator->errors());
                }
                $blog = Blog::create($input);
                $message = 'Blog created successfully.';
                $status = true;
        
                //Call function for response data
                $response = $this->response($status, $blog, $message);
                return $response;
            }

      
    public function update(Request $request, $id)
    {
        //Get request data
        $input = $request->all();

        //Validate requested data
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            $message = $validator->errors();
            $blog = [];
            $status = 'fail';
            $response = $this->response($status, $blog, $message);
            return $response;
        }

        //Update blog
        $blog = Blog::find($id)->update(['name' => $input['name'], 'description' => $input['description']]);
        $message = 'Blog updated successfully.';
        $status = true;

        //Call function for response data
        $response = $this->response($status, $blog, $message);
        return $response;
    }

    public function show($id)
    {
        $blog = Blog::find($id);

        //Check if the blog found or not.
        if (is_null($blog)) {
            $message = 'Blog not found.';
            $status = false;
            $response = $this->response($status, $blog, $message);
            return $response;
        }
        $message = 'Blog retrieved successfully.';
        $status = true;

        //Call function for response data
        $response = $this->response($status, $blog, $message);
        return $response;
    }

    public function destroy($id)
    {
        //Delete blog
        $blog = Blog::findOrFail($id);
        $blog->delete();
        $message = 'Blog deleted successfully.';
        $status = true;

        //Call function for response data
        $response = $this->response($status, $blog, $message);
        return $response;
    }

    public function response($status, $blog, $message)
    {
        //Response data structure
        $return['success'] = $status;
        $return['data'] = $blog;
        $return['message'] = $message;
        return $return;
    }

}
