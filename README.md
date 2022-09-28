I have mentioned comments with every line of my code so that you could easily get hands on things, follow my comments and you will get everything.
Incase of any confusions, ask me anything I will explain briefly.

I have done my own Email configuration setup on Mailtrap.io, you can use yours in .env file

I have my own tiwilio keys in .env, you can set up your own, After providing your credentials in .env, go to Api_UserController Line 59 and 172 and remove my hardcoded number, you will find my comment on those lines too, use "$user->phone" instead.

In Api_userController Line 130, i have mentioned a comment for handling some responses, but as those changes are made in vendor it would not reflect with you, you can customize as you own, I am providing code for that below:

if ($e instanceof ModelNotFoundException) { //Customized response for user not found
    return response()->json([
	'status' => false,
	'message' => 'No record was found',
	'result' => (object) [],
	], 404);
}
copy the above code and paste in start of "render" function in "Illuminate\Foundation\Exceptions\Handler"

As I have used resource routes so these are the following Web and Api Routes

API Routes:

Index:
URL => api/user, name=> user.index, method => GET|HEAD

Store:
URL => api/user, name=> user.store, method => POST

Create:
URL => api/user/create, name=> user.create, method => GET|HEAD

Show:
URL => api/user/{user}, name=> user.show, method => GET|HEAD

Update:
URL => api/user/{user}, name=> user.update, method => PUT|PATCH

Destroy:
URL => api/user/{user}, name=> user.destroy, method => DELETE

Edit:
URL => api/user/{user}/edit, name=> user.edit, method => GET|HEAD


Web Routes:

Index:
URL => user, name=> user.index, method => GET|HEAD

Store:
URL => user, name=> user.store, method => POST

Create:
URL => user/create, name=> user.create, method => GET|HEAD

Show:
URL => user/{user}, name=> user.show, method => GET|HEAD

Update:
URL => user/{user}, name=> user.update, method => PUT|PATCH

Destroy:
URL => user/{user}, name=> user.destroy, method => DELETE

Edit:
URL => user/{user}/edit, name=> user.edit, method => GET|HEAD
