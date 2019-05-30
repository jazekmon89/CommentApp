<?php

namespace App\Http\Controllers;

use App\Comment;
use Validator;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::where('level',1)->get()->all(); // get all level 1 comments
        if(count($comments)){
            foreach($comments as $k=>$i){
                $level2 = Comment::where('parent_id',$i->id)->where('level',2);
                if($level2->exists()){ // check if there are child comments (lvl 2)
                    $level2 = $level2->get()->all(); // get all child comments
                    foreach($level2 as $h=>$j){ // we still need to check lvl 3
                        $level3 = Comment::where('parent_id',$j->id)->where('level',3);
                        if($level3->exists()){ // if there are child comments (lvl 3)
                            $j->level3 = $level3->get()->all(); // get child comments
                            $level2[$h] = $j; // we update the specific lvl 2 attributes
                        }
                    }
                }
                $comments[$k]->level2 = $level2; // now we have all the lvl 2 and 3 comments
            }
        }
        return response()->json(['comment'=> $comments], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // check if inputs are valid
        $validator = Validator::make($data, [
            'name'      => 'required|alpha|max:100',
            'message'   => 'required|string',
            'parent_id' => 'numeric|nullable'
        ]);
        // return the error if there are
        if($validator->fails()){
            return response()->json([
                'messages' => $validator->messages(),
            ], 400);
        }
        // This is the only way that I know of to filter out malicious texts:
        $data['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $data['message'] = filter_var($data['message'], FILTER_SANITIZE_STRING);
        /* if request has a parent_id, we have to save this new comment as
         * a child comment for the parent comment. What I did was save the
         * id of the comment where a user tried to comment as parent id
         * then get the level (nesting) of the parent and increment by 1
         * so we can track what level we are now upon saving the comment.
         */
        if($data['parent_id']){
            $parent = Comment::where('id', $data['parent_id']);
            $level = 1; // first level, by default
            if($parent->exists()){
                $parent = $parent->select('level')->get()->first(); // get parent level
                $level = $parent->level + 1; // increment by 1 if it has a parent
            }else{ // if tricked, I just save it as a lvl 1 comment or we can just skip right?
                $parent = null; // default for lvl 1
                $level = 1; // default for lvl 1
            }
            if($level <= 3){ // we only have to save comments up to a maximum of 3 levels
                $comment = new Comment;
                $comment->name = $data['name'];
                $comment->message = $data['message'];
                $comment->parent_id = $data['parent_id'];
                $comment->level = $level;
                $comment->save();
            }
        }else{ // default for lvl 1 comments
            $comment = new Comment;
            $comment->name = $data['name'];
            $comment->message = $data['message'];
            $comment->parent_id = null;
            $comment->level = 1;
            $comment->save();
        }
        return response()->json([
            'messages' => 'Success',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
