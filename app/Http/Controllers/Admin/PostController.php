<?php

namespace App\Http\Controllers\Admin;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Model\user\post;
use App\Model\user\category;
use App\Model\user\tag;
use App\Model\admin\admin;
use App\Model\admin\role;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Notifications\NewAuthorPost;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('posts.create','posts.update','posts.delete')) {
            foreach (Auth::user()->roles as $role) {
                if ($role->id == 4) {
                    $posts=post::all();
                } else {
                    $user_id=Auth::user()->id;
                    $posts=post::where('admin_id', $user_id)->get();
                }
            }
            return view('admin.post.show', compact('posts'));
        }
        return redirect(route('admin.home'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (Auth::user()->can('posts.create')) {
            $tags=tag::all();
            $categories=category::all();
            return view('admin.post.post', compact('tags', 'categories'));
        }
        return redirect(route('admin.home'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'title'=>['required','unique:posts'],
            'body'=>'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'tags'=>'required',
            'categories'=>'required'
        ]);
        $post= new post;
        $post->title=$request->title;
        $post->subtitle=$request->subtitle;
        $post->slug=str_slug($request->title);
        $post->language=$request->language;
        if (Auth::user()->can('posts.view')) {
            $post->status=$request->publish? : $request['status']=0;
        }
        $post->meta_keyword=$request->metakeyword;
        $post->meta_description=$request->metadescription;
        $post->admin_id=Auth::user()->id; 
        $image = $request->file('image');
        if ($request->hasfile('image')) {
            if (isset($image)) {
                $imageName  = md5(time()).'.'.$image->getClientOriginalExtension();
                $postImage = Image::make($image)->resize(1920, 820)->encode();
                $postImage1 = Image::make($image)->resize(752, 353)->encode();
                $postImage2 = Image::make($image)->resize(360, 220)->encode();
                $postImage3 = Image::make($image)->resize(302, 183)->encode();
                $postImage4 = Image::make($image)->resize(263, 180)->encode();
                $postImage5 = Image::make($image)->resize(195, 180)->encode();
                $postImage6 = Image::make($image)->resize(62, 62)->encode();
                Storage::disk('public')->put('images/post_1920X820/'.$imageName, $postImage);
                Storage::disk('public')->put('images/post_752X353/'.$imageName, $postImage1);
                Storage::disk('public')->put('images/post_360X220/'.$imageName, $postImage2);
                Storage::disk('public')->put('images/post_302X183/'.$imageName, $postImage3);
                Storage::disk('public')->put('images/post_263X180/'.$imageName, $postImage4);
                Storage::disk('public')->put('images/post_195X180/'.$imageName, $postImage5);
                Storage::disk('public')->put('images/post_62X62/'.$imageName, $postImage6);
            } else {
                $imageName = "default.png";
            }
        } 
       $post->image=$imageName;
       $detail=$request->input('body');

        $dom = new \DomDocument();

        @$dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    

        $images = $dom->getElementsByTagName('img');

        foreach($images as $img){
			$src = $img->getAttribute('src');
			
			// if the img source is 'data-url'
			if(preg_match('/data:image/', $src)){
				
				// get the mimetype
				preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
				$mimetype = $groups['mime'];
				
				// Generating a random filename
				$filename = uniqid();
				$filepath = "/images/$filename.$mimetype";
	
				// @see http://image.intervention.io/api/
				$image = Image::make($src)
				  ->resize(752, 353)
				  ->encode($mimetype, 100) 	// encode file to the specified mimetype
				  ->save(Storage::disk('public')->put($filepath));
				
				$new_src = asset($filepath);
				$img->removeAttribute('src');
				$img->setAttribute('src', $new_src);
			} // <!--endif
		} // <!--endforeach
        
        
        $post->body = $dom->saveHTML();
        

       if ($post->save()) {
        $post->tags()->sync($request->tags);
        $post->categories()->sync($request->categories);
        foreach (Auth::user()->roles as $role) {
            if ($role->id != 4) {
                $role=role::where('id', 4)->first();
                $user=$role->admin->where('status', 1)->all();
                Notification::send($user, new NewAuthorPost($post));
            }
        }
           Toastr::success('Post Successfully Inserted', 'Success');
       }
        return redirect(route('post.index'));
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
        if (Auth::user()->can('posts.update')) {
            $post=post::with('tags', 'categories')->where('id', $id)->first();
            $tags=tag::where('language',$post->language)->get();
            $categories=category::where('language',$post->language)->get();
            return view('admin.post.edit', compact('post', 'tags', 'categories'));
        }
        return redirect(route('admin.home'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[
            'title'=>'required|unique:posts,title,'.$id,
            'body'=>'required',
            'image' => 'image|mimes:jpeg,png,jpg'
        ]);

        $post= post::find($id);
        $image = $request->file('image');
        if ($request->hasfile('image')) {
            if (isset($image)) {
                $imageName  = md5(time()).'.'.$image->getClientOriginalExtension();
                if ($post->image != "default.png") {
                    if (Storage::disk('public')->exists('images/post_1920X820/'.$post->image)) {
                        Storage::disk('public')->delete('images/post_1920X820/'.$post->image);
                    }
                    if (Storage::disk('public')->exists('images/post_752X353/'.$post->image)) {
                        Storage::disk('public')->delete('images/post_752X353/'.$post->image);
                    }
                    if (Storage::disk('public')->exists('images/post_360X220/'.$post->image)) {
                        Storage::disk('public')->delete('images/post_360X220/'.$post->image);
                    }
                    if (Storage::disk('public')->exists('images/post_302X183/'.$post->image)) {
                        Storage::disk('public')->delete('images/post_302X183/'.$post->image);
                    }
                    if (Storage::disk('public')->exists('images/post_263X180/'.$post->image)) {
                        Storage::disk('public')->delete('images/post_263X180/'.$post->image);
                    }
                    if (Storage::disk('public')->exists('images/post_195X180/'.$post->image)) {
                        Storage::disk('public')->delete('images/post_195X180/'.$post->image);
                    }
                    if (Storage::disk('public')->exists('images/post_62X62/'.$post->image)) {
                        Storage::disk('public')->delete('images/post_62X62/'.$post->image);
                    }
                } 
                else {
                }
                $postImage = Image::make($image)->resize(1920, 820)->encode();
                $postImage1 = Image::make($image)->resize(752, 353)->encode();
                $postImage2 = Image::make($image)->resize(360, 220)->encode();
                $postImage3 = Image::make($image)->resize(302, 183)->encode();
                $postImage4 = Image::make($image)->resize(263, 180)->encode();
                $postImage5 = Image::make($image)->resize(195, 180)->encode();
                $postImage6 = Image::make($image)->resize(62, 62)->encode();
                Storage::disk('public')->put('images/post_1920X820/'.$imageName, $postImage);
                Storage::disk('public')->put('images/post_752X353/'.$imageName, $postImage1);
                Storage::disk('public')->put('images/post_360X220/'.$imageName, $postImage2);
                Storage::disk('public')->put('images/post_302X183/'.$imageName, $postImage3);
                Storage::disk('public')->put('images/post_263X180/'.$imageName, $postImage4);
                Storage::disk('public')->put('images/post_195X180/'.$imageName, $postImage5);
                Storage::disk('public')->put('images/post_62X62/'.$imageName, $postImage6);
            } 
            else {
                $imageName = $post->image;
            }
            $post->image=$imageName;
        }
        $post->title=$request->title;
        $post->subtitle=$request->subtitle;
        $post->slug=str_slug($request->title);
        if (Auth::user()->can('posts.view')) {
            $post->status=$request->publish? : $request['status']=0;
        }
        $post->meta_keyword=$request->metakeyword;
        $post->meta_description=$request->metadescription;
        $post->tags()->sync($request->tags);
        $post->categories()->sync($request->categories);
         $detail=$request->input('body');

         $dom = new \DomDocument();

         @$dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    

        $images = $dom->getElementsByTagName('img');

        foreach($images as $img){
			$src = $img->getAttribute('src');
			
			// if the img source is 'data-url'
			if(preg_match('/data:image/', $src)){
				
				// get the mimetype
				preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
				$mimetype = $groups['mime'];
				
				// Generating a random filename
				$filename = uniqid();
				$filepath = "images/$filename.$mimetype";
	
				// @see http://image.intervention.io/api/
				$image = Image::make($src)
				  // resize if required
				  ->resize(752, 353) 
				  ->encode($mimetype, 100) 	// encode file to the specified mimetype
				  ->save(Storage::disk('public')->put($filepath));
				
				$new_src = asset($filepath);
				$img->removeAttribute('src');
				$img->setAttribute('src', $new_src);
			} 
		} 
        $post->body= $dom->saveHTML();;
        
        if ($post->save()) {
            Toastr::success('Post Successfully Updated ', 'Success');
        }
        return redirect(route('post.index'));
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (Auth::user()->can('posts.delete')) {
        $user=post::find($id);
        if($user->image != "default.png")
        {
            if (Storage::disk('public')->exists('images/post_1920X820/'.$user->image)) {
                Storage::disk('public')->delete('images/post_1920X820/'.$user->image);
            }
            if (Storage::disk('public')->exists('images/post_752X353/'.$user->image)) {
                Storage::disk('public')->delete('images/post_752X353/'.$user->image);
            }
            if (Storage::disk('public')->exists('images/post_360X220/'.$user->image)) {
                Storage::disk('public')->delete('images/post_360X220/'.$user->image);
            }
            if (Storage::disk('public')->exists('images/post_302X183/'.$user->image)) {
                Storage::disk('public')->delete('images/post_302X183/'.$user->image);
            }
            if (Storage::disk('public')->exists('images/post_263X180/'.$user->image)) {
                Storage::disk('public')->delete('images/post_263X180/'.$user->image);
            }
            if (Storage::disk('public')->exists('images/post_195X180/'.$user->image)) {
                Storage::disk('public')->delete('images/post_195X180/'.$user->image);
            }
            if (Storage::disk('public')->exists('images/post_62X62/'.$user->image)) {
                Storage::disk('public')->delete('images/post_62X62/'.$user->image);
            }
            $user->delete();
        }
        else
        {
            $user->delete();
        }
        Toastr::success('Post Successfully Deleted', 'Success');
        return redirect()->back();
    }
    return redirect(route('post.index'));
    } 
    public function changeStatus(Request $request)
    {
        $user = post::find($request->user_id);
        $user->status = $request->status;
        $user->save();
        return response()->json(['success'=>'Status change successfully.']);
    }
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $request->file('upload')->move('../storage/app/public/images', $fileName);
   
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/images/'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }
    public function postselect(Request $request)
    {        
            $categories=category::where('language', $request->select_id)->get();
            $tags=tag::where('language', $request->select_id)->get();
            return response()->json(['category'=>$categories,'tag'=>$tags]);
    }

}
