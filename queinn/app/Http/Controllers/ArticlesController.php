<?php

namespace App\Http\Controllers;

use App\AdminUser;
use App\BlogTags;
use Illuminate\Http\Request;
use App\Pages;
use App\Blogs;
use App\BlogCategories;
use App\BlogComments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Redirect;
use Validator;
use Response;
use Auth;
use App\PointsSettings;
use App\PointsLogs;
use App\User;


class ArticlesController extends Controller
{
	protected $no_of_rows = 12;
	
    public function index(){
        $author_name = AdminUser::first();
        $author_name     = $author_name->name;
		$articles 	= Blogs::where('visibility',1)->orderBy('created_at', 'desc')->paginate($this->no_of_rows);
        $recent_articles 	= Blogs::where('visibility',1)->orderBy('created_at', 'desc')->paginate($this->no_of_rows);
		$articlesCategories = BlogCategories::where('visible_status',1)->orderBy('name', 'asc')->get();
		$page 		= Pages::where('slug','blogs')->first();

        //	For Serach Query set initially to blank
        $q = '';

        return view('articles',compact('articles', 'page','articlesCategories', 'recent_articles', 'q', 'author_name'));
	}
	
	public function ArticlesByCategory($catslug){
        $author_name = AdminUser::first();
		$author_name     = $author_name->name;
		$articlesCategory = BlogCategories::where('slug',$catslug)->where('visible_status',1)->orderBy('name', 'asc')->first();
		if(!empty($articlesCategory)){
				$articles 	= Blogs::where('visibility',1)->whereRaw('FIND_IN_SET("'.$articlesCategory->id.'",categories)')->orderBy('created_at', 'desc')->paginate($this->no_of_rows);
				$page 		= BlogCategories::where('slug', $catslug)->first();
				$articlesCategories = BlogCategories::where('visible_status',1)->orderBy('name', 'asc')->get();

            //	For Serach Query set initially to blank
            $q = '';
            return view('articles-by-category',compact('articlesCategory', 'page','articles', 'articlesCategories', 'q', 'author_name'));
		}
	}

    //	Articles by Tag

    public function articlesByTag($tagslug){
        $author_name = AdminUser::first();
        $author_name     = $author_name->name;
        $articlesTag = BlogTags::where('slug',$tagslug)->where('status',1)->orderBy('name', 'asc')->first();
        if(!empty($articlesTag)){
            $articles 	= Blogs::where('visibility',1)->whereRaw('FIND_IN_SET("'.$articlesTag->id.'",tags)')->orderBy('created_at', 'desc')->paginate($this->no_of_rows);
            $page 		= Pages::where('slug','blogs')->first();

            //	For Serach Query set initially to blank
            $q = '';
            return view('articles-by-tag',compact('articlesTag', 'page','articles', 'q', 'author_name'));

        }
    }

    // Articles by Slug

	public function articleBySlug($slug){
        $author_name = AdminUser::first();
		$author_name     = $author_name->name;
		
		$articleDetail 	= Blogs::where('visibility',1)->where('slug',$slug)->first();

		if(!empty($articleDetail->id)){
            $previous_post 	= Blogs::where('visibility',1)->where('id',$articleDetail->id-1)->first();
            $next_post 	= Blogs::where('visibility',1)->where('id',$articleDetail->id+1)->first();
        }

        $related_posts 	= Blogs::where('related_post',1)->get();

		if(!empty($articleDetail)) {
            $page = Blogs::where('slug', $slug)->first();
            $articlesCategories = BlogCategories::where('visible_status', 1)->orderBy('name', 'asc')->get();
            $articleCategoryDetail = BlogCategories::where('visible_status', 1)->whereIn('id', explode(',', $articleDetail->categories))->orderBy('name', 'asc')->get();

            $articlesComments = BlogComments::where('status', 1)->where('blog_id', $articleDetail->id)->orderBy('created_at', 'desc')->get();

            $get_tag = Blogs::where('slug', $slug)->first()->tags;
            $tags = explode(',', $get_tag);

            foreach ($tags as $tag) {
                $getTagName[] = BlogTags::where('id', $tag)->first();
            }

//            foreach ($getTagName as $tag)
//            {
//                if(!empty($tag->name)) {
//                    $tagName[] = $tag->name;
//                }
//                else{
//                    $tagName[] = '';
//                }
//            }
            //	For Serach Query set initially to blank
            $q = '';

            // View Counter
            if(session()->get($slug) == ''){
                $articleDetail->view_count = $articleDetail->view_count+1;
                $articleDetail->save();
            }
            session()->put($slug, 1);

			return view('article-detail',compact('articlesCategories', 'page','articleDetail','articleCategoryDetail','articlesComments', 'getTagName', 'previous_post', 'next_post', 'related_posts', 'q' , 'author_name'));
		}else{
			return redirect('articles');
		}
	}
	
	public function leaveReply(Request $request){

			$rules = [
				'name'	  => 'required',
				'email' => 'required|email',
				'message' => 'required'
			];
			
			$validator = Validator::make($request->all(), $rules);
			
			$input = $request->all();

			if ($validator->passes()) {
					$blog_id  	= $request->input('article_id');
					$name  		= $request->input('name');
					$email  	= $request->input('email');
					$mobile  	= $request->input('mobile');
					$comment  	= $request->input('message');
					
					$blogcomments = new BlogComments();
					$blogcomments->user_id		= 0;
					$blogcomments->blog_id		= $blog_id;
					$blogcomments->name 		= $name;
					$blogcomments->email 		= $email;
					$blogcomments->mobile 		= $mobile;
					$blogcomments->comment 		= $comment;
					$blogcomments->status 		= 2;
					$blogcomments->created_at 	= date('Y-m-d H:i:s');
					$blogcomments->updated_at 	= date('Y-m-d H:i:s');

					
					
					if($blogcomments->save()){

						//Leave a Reply Notification Email - Admin Copy
						$emailto        = env("ADMIN_MAIL");
						$subject        = 'New Reply on Article - '.fieldtofield('blogs', 'id', $blog_id, 'title');  
						$messagebody    = array(
                                                'name'  	=> $name,
                                                'email'  	=> $email,
                                                'comment'  	=> $comment,
                                                'blog_name' => fieldtofield('blogs', 'id', $blog_id, 'title'),
                                                'blog_slug' => fieldtofield('blogs', 'id', $blog_id, 'slug')
                                            );

						$template       = 'email-templates.leave-a-reply';
						$header         = array('from' => $name);
						send_smtp_email($emailto,$subject,$messagebody,$template, $header);
						return Response::json(['success' => '1']);
					}
			}
			return Response::json(['errors' => $validator->errors()]);
	}

    //	Search
    public function articleSearch(Request $request){
        $author_name = AdminUser::first();
        $author_name     = $author_name->name;
        $q = $request->input('s');
        if(!empty($q)){
            $page 		= Pages::where('slug','blogs')->first();
            $articles   = Blogs::where('title','LIKE','%'.$q.'%')->orWhere('description','LIKE','%'.$q.'%')->paginate($this->no_of_rows);
            return view('articleSearch',compact('page', 'articles', 'q', 'author_name'));
        }
        else{
            return redirect('/');
        }
    }
}
