<?php

namespace App\Http\Controllers;
use App\Page;
use Illuminate\Http\Request;
use DB;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Mail\OrderShipped;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\Newsletter;
use Illuminate\Support\Facades\Redirect;

class PageController extends Controller
{
  public function show($id){
    $page=Page::findOrFail($id);
    return view('pages.show', compact('page'));
  }

  public function index(){
    $pages = Page::all();
    return view('pages.index', compact('pages'));
  }
public function plus($id){

  $user = auth()->user();
  $user_check = DB::table('user_click_article')
    ->where('article_id', '=', $id)
    ->where('user_id', '=', $user->id)
    ->first();
    $results = DB::select('select * from user_click_article where user_id = ? and article_id = ?', [$user->id, $id]);

    if(count($results)>0){
      if(($user_check->reakcja)=='0'){
        $att = DB::table('cards')
          ->where('id', '=', $id)
          ->first();
        $new_plus=($att->plus)+1;

        DB::update('update cards set plus = ? where id = ?',[$new_plus,$id]);
        DB::update('update user_click_article set reakcja = ? where user_id = ?',['1',$user->id]);
      }
    }else{
      $att = DB::table('cards')
        ->where('id', '=', $id)
        ->first();
      $new_plus=($att->plus)+1;
      DB::insert('insert into user_click_article (article_id, user_id, reakcja ) values (?, ?, ?)', [$id, $user->id, '1']);
      DB::update('update cards set plus = ? where id = ?',[$new_plus,$id]);
      DB::update('update user_click_article set reakcja = ? where user_id = ?',['1',$user->id]);
    }


  return redirect('/articles');
}

public function minus($id){

  $user = auth()->user();
  $user_check = DB::table('user_click_article')
    ->where('article_id', '=', $id)
    ->where('user_id', '=', $user->id)
    ->first();
    $results = DB::select('select * from user_click_article where user_id = ? and article_id = ?', [$user->id, $id]);

    if(count($results)>0){
      if(($user_check->reakcja)=='0'){
        $att = DB::table('cards')
          ->where('id', '=', $id)
          ->first();
        $new_minus=($att->minus)+1;

        DB::update('update cards set minus = ? where id = ?',[$new_minus,$id]);
        DB::update('update user_click_article set reakcja = ? where user_id = ?',['1',$user->id]);
      }
    }else{
      $att = DB::table('cards')
        ->where('id', '=', $id)
        ->first();
      $new_minus=($att->minus)+1;
      DB::insert('insert into user_click_article (article_id, user_id, reakcja ) values (?, ?, ?)', [$id, $user->id, '1']);
      DB::update('update cards set minus = ? where id = ?',[$new_minus,$id]);
      DB::update('update user_click_article set reakcja = ? where user_id = ?',['1',$user->id]);
    }


  return redirect('/articles');
}
  public function main(){
    $success = 0;
    return view('pages.main', compact('success'));
  }
  public function articles(){
    if (Auth::check()) {
    $logged=true;
}else{
    $logged=false;
}
    $comments=DB::table('comments_posts')->get();
    $articles = DB::table('cards')->get();
    $users=DB::table('users')->get();
    $wiadomosc = '0';
    return view('pages.articles', ['articles' => $articles, 'users' => $users, 'comments' => $comments], compact('logged', 'wiadomosc'));
  }
  public function admin(){
    return view('pages.admin');
  }
  public function posts(){
    $articles = DB::table('cards')->paginate(7);

    return view('pages.admin.posts', ['articles' => $articles]);
  }
  public function posts_create(Request $request){

  DB::insert('insert into cards (img, tittle, content, autor ) values (?, ?, ?, ?)', [$request->input('img'), $request->input('title'), $request->input('content'), $request->input('autor')]);
  if($request->input('rola')=='admin'){
  return redirect('/admin/posts');
  }
  if($request->input('rola')=='writer'){
  return redirect('/writer/posts');
  }

}
public function posts_delete($id){
  DB::table('cards')->where('id', '=', $id)->delete();

  if(Auth::user()->hasRole('Writer')){
    return redirect('/writer/posts');
  }else if(Auth::user()->hasRole('Admin')){
    return redirect('/admin/posts');
  }else{
    return redirect('/');
  }




}
public function posts_edit(Request $request){
DB::update('update cards set img = ?, tittle = ?, content = ? where id = ?',[$request->input('img_edit'),$request->input('title_edit'), $request->input('content_edit'), $request->input('post_id')]);
if(Auth::user()->hasRole('Admin')){
  return redirect('/admin/posts');
}else if(Auth::user()->hasRole('Writer')){
  return redirect('/writer/posts');

}else{
  return redirect('/');
}
}
public function writer_panel(){

  return view('pages.writer.panel');
}
public function users_list(){
  $users=DB::table('users')->paginate(4);
  $roles = DB::table('roles')->get();
  $user_roles = DB::table('roles_has_users')->get();


  $count = count($roles);
  return view('pages.admin.users',  ['users' => $users, 'roles' => $roles, 'user_roles' => $user_roles], compact('count'));
}
public function users_delete($id){
  $user = User::find($id);
  $user->delete();
  return redirect('/admin/users');
}
public function users_edit(Request $request){
  $cards_modify = DB::select('select * from cards where autor = ?', [$request->input('before_name')]);
  if(count($cards_modify)>0){
  DB::update('update cards set autor = ? where autor = ?',[ $request->input('name'), $request->input('before_name')]);
  }
  DB::update('update users set name = ? where name = ?', [$request->input('name'), $request->input('before_name')]);
  DB::update('update users set email = ? where name = ?', [$request->input('email'), $request->input('before_name')]);
   if($request->input('removeRadios')!='0'){
    $delete = DB::table('roles_has_users')->where([
    ['roles_id', '=', $request->input('removeRadios')],
    ['users_id', '=', $request->input('actual_user')],
    ])->delete();
    if ($delete) {
    return redirect('/admin/users');
    }

  }else if($request->input('addRadios')!='0'){
     $results = DB::select('select * from roles_has_users where users_id = ? and roles_id = ?', [$request->input('actual_user'), $request->input('addRadios')]);
     if(count($results)==0){
      DB::insert('insert into roles_has_users (users_id, roles_id, created_at, updated_at ) values (?, ?, ?, ?)', [$request->input('actual_user'), $request->input('addRadios'), date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
     return redirect('/admin/users');
 }

return redirect('/admin/users');


}
return redirect('/admin/users');
}
public function users_find(Request $request){
$roles_all = DB::table('roles')->get();
$user_roles_all = DB::table('roles_has_users')->get();

if(null !== $request->input('user_id') && $request->input('user_name') === null && $request->input('user_email') === null){
  $users = DB::table('users')->where('id', $request->input('user_id'))->get();
  $tab_roles;
  $roles2 = DB::table('roles_has_users')->where('users_id', $request->input('user_id'))->pluck('roles_id');
  foreach ($roles2 as $role2) {
    $roles = DB::table('roles')->where('id',$role2)->pluck('name');
    $tab_roles[$role2]=$roles;

  }
  $count_roles = DB::select('select * from roles');
  $count_score = count($count_roles);
  $user_roles;
  $bufor;
  for($i=0; $i<=$count_score; $i++){
    if(isset($tab_roles[$i])){
      $user_roles[$i] = $tab_roles[$i];

    }
  }








return view('pages.admin.users_finded', ['users' => $users, 'roles_all' => $roles_all, 'user_roles_all' => $user_roles_all], compact('count_score', 'user_roles'));




}else if(null !== $request->input('user_name') && $request->input('user_id') === null && $request->input('user_email') === null){
  $users = DB::table('users')->where('name', $request->input('user_name'))->get();
  $users2 = DB::table('users')->where('name', $request->input('user_name'))->pluck('id');
  $user_id;
  foreach ($users2 as $user) {
   $user_id=$user;
  }

  $tab_roles;
  $roles2 = DB::table('roles_has_users')->where('users_id', $user_id)->pluck('roles_id');
  foreach ($roles2 as $role2) {
    $roles = DB::table('roles')->where('id',$role2)->pluck('name');
    $tab_roles[$role2]=$roles;
  }
  $count_roles = DB::select('select * from roles_has_users');
  $count_score = count($count_roles);
  $user_roles;
  $bufor;
  for($i=0; $i<=$count_score; $i++){
    if(isset($tab_roles[$i])){
      $user_roles[$i] = $tab_roles[$i];
    }
  }









return view('pages.admin.users_finded', ['users' => $users, 'roles_all' => $roles_all, 'user_roles_all' => $user_roles_all], compact('count_score', 'user_roles'));



}else if(null !== $request->input('user_email') && $request->input('user_id') === null && $request->input('user_name') === null){
  $users = DB::table('users')->where('email', $request->input('user_email'))->get();
  $users2 = DB::table('users')->where('email', $request->input('user_email'))->pluck('id');
  $user_id;
  foreach ($users2 as $user) {
   $user_id=$user;
  }

  $tab_roles;
  $roles2 = DB::table('roles_has_users')->where('users_id', $user_id)->pluck('roles_id');
  foreach ($roles2 as $role2) {
    $roles = DB::table('roles')->where('id',$role2)->pluck('name');
    $tab_roles[$role2]=$roles;
  }
  $count_roles = DB::select('select * from roles_has_users');
  $count_score = count($count_roles);
  $user_roles;
  $bufor;
  for($i=0; $i<=$count_score; $i++){
    if(isset($tab_roles[$i])){
      $user_roles[$i] = $tab_roles[$i];
    }
  }









return view('pages.admin.users_finded', ['users' => $users, 'roles_all' => $roles_all, 'user_roles_all' => $user_roles_all], compact('count_score', 'user_roles'));




}else if(null !== $request->input('user_id') && null !== $request->input('user_name') && null !== $request->input('user_email')){
  $users = DB::table('users')->where([
  ['id', '=', $request->input('user_id')],
  ['name', '=', $request->input('user_name')],
  ['email', '=', $request->input('user_email')]
  ])->get();

  if(count($users)==1){
    $users2 = DB::table('users')->where('name', $request->input('user_name'))->pluck('id');
    $user_id;
    foreach ($users2 as $user) {
     $user_id=$user;
    }

    $tab_roles;
    $roles2 = DB::table('roles_has_users')->where('users_id', $user_id)->pluck('roles_id');
    foreach ($roles2 as $role2) {
      $roles = DB::table('roles')->where('id',$role2)->pluck('name');
      $tab_roles[$role2]=$roles;
    }
    $count_roles = DB::select('select * from roles_has_users');
    $count_score = count($count_roles);
    $user_roles;
    $bufor;
    for($i=0; $i<=$count_score; $i++){
      if(isset($tab_roles[$i])){
        $user_roles[$i] = $tab_roles[$i];
      }
    }
  }
return view('pages.admin.users_finded', ['users' => $users, 'roles_all' => $roles_all, 'user_roles_all' => $user_roles_all], compact('count_score', 'user_roles'));



}else{
  return redirect('/admin/users');
}


}
public function users_find_group(Request $request){
  $users = DB::table('users' )
    ->select('*')
    ->join('roles_has_users', 'roles_has_users.users_id', '=', 'users.id')
    ->where('roles_has_users.roles_id', $request->input('select_role'))
    ->paginate(7);
  $role = DB::table('roles')->where('id',$request->input('select_role'))->pluck('name');
  $roles = DB::table('roles')->get();
  $user_roles = DB::table('roles_has_users')->get();

  return view('pages.admin.groups_finded',  ['users' => $users,'roles' => $roles, 'user_roles' => $user_roles], compact('role'));
}
public function writer_panel_posts(){
  $name = Auth::user()->name;
  $posts = DB::table('cards')->where('autor', $name)->paginate(7);
  return view('pages.writer.posts', ['posts' => $posts], compact('name'));
}
public function newsletter(Request $request){
$results = DB::table('newsletter')
    ->where('adres', '=', $request->input('email'))
    ->get();
if(count($results)==0){
DB::insert('insert newsletter (adres) values (?)', [$request->input('email')]);
$success = 1;
return redirect('/');
}else{
  $success = 2;
return redirect('/');
}

}
public function admin_newsletter(){
  $mails = DB::table('newsletter')->get();
  $mails_sended = DB::table('news_sended')->paginate(8);
  return view('pages.admin.newsletter',['mails' => $mails, 'mails_sended' => $mails_sended]);
}

public function newsletter_create(Request $request){

    $title = $request->input('title');
    $content = $request->input('content');
    $mail = $request->input('mail');

    $data = array(
        'title' => $title,
        'content' => $content,
        'mail' => $mail,
    );
    $mails = DB::table('newsletter')->pluck('adres')->toArray();
    $ile = count($mails = DB::table('newsletter')->pluck('adres'));
    for($i = $ile-1; $i>=0; $i--){

      Mail::send('mails.exmpl', $data, function ($message) use($request, $mails, $i) {

        $emails=array('gobeast666@gmail.com','leoncio1601@gmail.com');
        $message->from($request->mail,'Moja Aplikacja');
        $message->to($mails[$i])->subject($request->input('title'));

    });
  }


    DB::insert('insert into news_sended (title, content, created_at ) values (?, ?, ?)', [$request->input('title'), $request->input('content'), date('Y-m-d H:i:s') ]);

   return redirect('/admin/newsletter');
  }
  public function comment_add(Request $request){
    DB::insert('insert into comments_posts (users_id, users_name, cards_id, comments, created_at, updated_at ) values (?, ?, ?, ?, ?, ?)', [$request->input('user_id'), $request->input('user_name'), $request->input('card_id'), $request->input('comment'), date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
    $open = (int)$request->input('card_id');
    $logged=true;
    $comments=DB::table('comments_posts')->get();
    $articles = DB::table('cards')->get();
    $users=DB::table('users')->get();
    return redirect()->route('articles', ['articles' => $articles, 'users' => $users, 'comments' => $comments])->with('logged',$logged)->with('open',$open);
  }
  public function comment_del($id){
    $card = DB::table('comments_posts')->where('id', '=', $id)->value('cards_id');
    DB::table('comments_posts')->where('id', '=', $id)->delete();
    $open = (int)$card;
    $logged=true;
    $comments=DB::table('comments_posts')->get();
    $articles = DB::table('cards')->get();
    $users=DB::table('users')->get();

    return redirect()->route('articles', ['articles' => $articles, 'users' => $users, 'comments' => $comments])->with('logged',$logged)->with('open',$open);
  }
    public function comment_edit(Request $request){
      $card = DB::table('comments_posts')->where('id', '=', $request->input('comment_id'))->value('cards_id');
      DB::update('update comments_posts set comments = ? where id = ?',[$request->input('edited_com') ,$request->input('comment_id')]);
      DB::update('update comments_posts set updated_at = ? where id = ?',[date('Y-m-d H:i:s') ,$request->input('comment_id')]);
      $open = (int)$card;
      $logged=true;
      $comments=DB::table('comments_posts')->get();
      $articles = DB::table('cards')->get();
      $users=DB::table('users')->get();

      return redirect()->route('articles', ['articles' => $articles, 'users' => $users, 'comments' => $comments])->with('logged',$logged)->with('open',$open);
    }
    public function moderator(){
      return view('pages.moderator.moderator');
    }
}
