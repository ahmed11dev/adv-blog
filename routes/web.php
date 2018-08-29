<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function(){
    return view('welcome');
});


Route::group(['namespace' => 'auth'],function(){
        // --- register
        Route::get('/register',[
            'uses' => 'RegisterController@getRegister',
            'as' => 'register',
        ]);
        Route::post('/register',[
            'uses' => 'RegisterController@postRegister',
            'as' => 'register',
        ]);
    // --- login
        Route::get('/login',[
            'uses' => 'LoginController@getLogin',
            'as' => 'login',
        ]);
        Route::post('/login',[
            'uses' => 'LoginController@postLogin',
            'as' => 'login',
        ]);
        Route::post('/logout',[
            'uses' => 'LoginController@Logout',
            'as' => 'logout',
        ]);
        // ---- delete this later
    Route::get('/logout',[
        'uses' => 'LoginController@Logout',
        'as' => 'logout',
    ]);

    //------- activation code by email
    Route::get('/activate/{email}/{token}','EmailActivationController@activateUser');

    // ------ reset password
    Route::post('/reset',[
        'uses' => 'ForgotPasswordController@postForgotPassword',
        'as' => 'reset',
    ]);
    Route::view('reset','auth.forgot-password');
    //---- reset update form
    Route::get('reset/{email}/{token}','ResetPasswordController@getPasswordResetThroughEmail')->name('password-reset');
    Route::post('reset-password','ResetPasswordController@postPasswordResetThroughEmail')->name('password-reset');

    //-------------- reset by question
    Route::get('/resetBySecurityQuestion',[
        'uses' => 'ResetPasswordController@getPasswordResetThroughQuestion',
        'as' => 'reset.security',
    ]);
    Route::post('/resetBySecurityQuestion/stage1',[
        'uses' => 'ResetPasswordController@postPasswordResetThroughQuestion1',
        'as' => 'reset.security1',
    ]);
    Route::post('/resetBySecurityQuestion/stage2',[
        'uses' => 'ResetPasswordController@postPasswordResetThroughQuestion2',
        'as' => 'reset.security2',
    ]);
    Route::post('/resetBySecurityQuestion/stage3',[
        'uses' => 'ResetPasswordController@postPasswordResetThroughQuestion3',
        'as' => 'reset.security3',
    ]);
    //-------------- reset by question end

    //-------------- change password
    Route::get('/change-password',[
        'uses' => 'ChangePasswordController@getChangePassword',
        'as' => 'change-password',
    ])->middleware('admin');
    Route::post('/change-password',[
        'uses' => 'ChangePasswordController@postChangePassword',
        'as' => 'change-password',
    ])->middleware('admin');


});

Route::get('/home',function(){
    return view('home');
})->name('home');

// ---------      admin and user dashbord -------
Route::get('/user/dashbord',function(){
    return view('user.dashbord');
})->name('user.dashbord')->middleware('user');

Route::get('/admin/dashbord','adminController@index')->name('admin.dashbord');
// ---------      admin and user dashbord  end-------

Route::get('/test',function(){
    if (\App\admin::listOnlineUsers() !== null) {
        foreach (\App\admin::listOnlineUsers() as $user) {
            dd($user->email);
        }
    }else{
        return 'no user online';
    }
});



// resource post
Route::resource('/posts','PostController')->middleware('admin');

Route::get('unapproved',[
    'uses' => 'PostController@listUnApproved',
    'as' => 'posts.unapproved',
])->middleware('admin');

Route::post('/posts/approve/{id}',[
    'uses' => 'PostController@approvePost',
    'as' => 'posts.approve',
])->middleware('admin');


// ------------- profile
Route::group(['middleware'=> ['admin','user']],function(){
    Route::get('/profile/{username}',[
        'uses' => 'UserController@getProfile',
        'as' => 'profile',
    ]);
    Route::post('/profile',[
        'uses' => 'UserController@postProfile',
        'as' => 'profile',
    ]);
    //------------- tags

    Route::resource('/tags','TagController');
    Route::get('/popular/tags','TagController@sortByPopularity');
});

//---------------------  comment
Route::get('/comments',['uses' =>'CommentController@index','as'=>'comments.index']);
Route::get('/comments/{comment}',['uses' =>'CommentController@show','as'=>'comments.show']);
Route::get('/comments/{comment}/{post}',['uses' =>'CommentController@edit','as'=>'comments.edit']);
Route::post('/comments/{post}',['uses' =>'CommentController@store','as'=>'comments.store']);
Route::put('/comments/{comment}/',['uses' =>'CommentController@update','as'=>'comments.update']);
Route::delete('/comments/{comment}',['uses' =>'CommentController@destroy','as'=>'comments.destroy']);

//---------------  reply
Route::get('/replies/{reply}','RepliesController@show')->name('replies.show');
Route::get('/replies/{reply}/{post}','RepliesController@edit')->name('replies.edit');
Route::post('/replies/{comment}/{post}','RepliesController@store')->name('replies.store');
Route::PUT('/replies/{reply}/{comment}/{post}','RepliesController@update')->name('replies.update');
Route::delete('/replies/{reply}','RepliesController@destroy')->name('replies.destroy');




// ----  upgrade permissions
/*
Route::get('/test',function(){
    \App\admin::upgradeUser(1,['admin.show'=>true,'admin.delete'=>true,'admin.edit'=>true,'admin.create'=>true,'user.approve' => true,]);
    $user =\Sentinel::findById(1);
   // dd($user->roles->first()->permissions);
});
*/

//  create admin level
/*
Route::get('/roles',function(){
    $role = Sentinel::getRoleRepository()->createModel()->create([
        'name' => 'user',
        'slug' => 'user',
        'permissions' => ['user.show' => true,'user.delete' => false,'user.edit' => true,'user.create' => true,'user.approve' => true,],
    ]);
});

*/



