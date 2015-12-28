@extends('layouts.default-with-sidebar')


@section('content')

<h1>IRC</h1>

<h3>So you want to be an IRC God?</h3>
<p>IRC (Internet Relay Chat) is an almost 30 year old text chat protocol that allows you to join Channels (think Chat rooms) within servers and talk to anyone else connected. UCC Netsoc has an IRC server running that's part of the Intersocs network, Intersocs being a network of many of the University Netsoc's around Ireland.</p>

<p>In order to connect to the IRC network you need to log into our server via <a href="{{URL::route('static/ssh')}}">SSH</a>. Some SSH clients are Putty for Windows, Crosh for Chrome/ChromeOS, or the Terminal for Linux and OSX. Once you log in with  {{ Auth::user()->uid }}@leela.netsoc.co and whatever plassword you created when signing up you will be given access to our server's command line.</p>

<p>From here the IRC client can be opened to start chatting. Our favourite client is called Weechat so we recommend that. We also use a program called Screen to make sure that, even if we logout or lose connection to SSH, our IRC client will still run happily. To create a new Screen and automatically open Weechat in it, type "<code>irc</code>"  (without quotes).</p>

<p>Weechat should now be opened and have automatically connected you to our IRC server and join the #uccnetsoc and  #cork channels.</p>


<h3>Making sense of Weechat.</h3>
<p>To switch between channels you're connected to you use keyboard shortcuts. To switch to next channel press <code>alt</code> + <code>→</code> and to switch to the previous channel press <code>alt</code> + <code>←</code>. To read some of the chat channel that has disappeared off screen due to old age, use <code>PageUp</code> and <code>PageDown</code> to scroll.</p>

<p>Along the bottom blue strip of the screen, just above where you type, Weechat will show some useful info about the channels, from left to right these are current time, total number of channels opened, server the current channel is part of (irc/netsoc), number assigned to current channel, current channel name, current channel "mode" (ignore this), and number of users in the current channel. Finally it will show details of new messages  in unselected channels here: <code>H:</code> followed by channel number, and then number of new messages (which can be split  up into different catagories like join/leave messages, highlights and regular messages).</p>

<p>Along the right is the nicknames of all the users in the current Channel, and at the top if the current "topic" of the channel.</p>

<p>Weechat also has a nice feature to let you display more than one chat on the screen at any time by using split screen. The command /window splitv 50 will split the screen into two equally sized windows (each 50% wide). /window splith 50 will also work for horizontal split. Try experiment with different percentages and combinations. Switching between which window has focus in a split screen setup is fun by pressing <code>F7</code> and <code>F8</code> to cycle through them.</p>

<p>Finally, if you mention someones exact nickname that's in the current channel in a message, they will get a notification (called a highlight). Typing the beginning of someone's nickname and hitting Enter will  autocomplete the name, just like the way the command line does, so that's handy.</p>


<h3>WTF does Screen do?</h3>
<p>Screen is a lovely little program perfect for use with IRC - it lets you keep Weechat running endlessly even if you disconnect from SSH so that you never miss anything from the chat. For us, typing irc as mentioned above created a Screen and opened Weechat. So what happens if you disconnect from SSH and reconnect later? Well, when you reconnect you wont be "attached" to the Screen anymore, you'll be back in plain old command line. Again, typing irc in here will reattach you to the screen that you created earlier and has been patiently awaiting your return, Weechat still open, just as you left it. If you want to detach from the Screen manually pressing <code>Ctrl</code> + <code>A</code> followed by <code>D</code> (for Detach) will bring you back to regular old command line. Here you can type logout to exit the SSH connection (or you could just close the SSH client on your machine without detaching if you like, I won't tell).</p>


<h3>You got this far and are looking for more advanced Weechat commands?</h3>
<p>Well, here's some then...</p>

<ul class="collection">
	<li class="collection-item"><code>/connect</code> SERVERNAME will let you connect to other server outside of intersocs if you like. It's a big world out there.</li>
	<li class="collection-item"><code>/join</code> CHANNELNAME joins other channels once you're connected to a server.</li>
	<li class="collection-item"><code>/list</code> will give a list of every channel available in the current server to help you find ones to join (Hint: make sure you have Weechat channel number 1 selected if you want to be able to read the output)</li>
	<li class="collection-item"><code>/nick</code> NEWNICKNAME will change your nickname if you like.</li>
	<li class="collection-item"><code>/leave</code> will make you leave the current channel but leave the channel window open.</li>
	<li class="collection-item"><code>/close</code> will do the above, but close the channel window instead.</li>
	<li class="collection-item"><code>/msg</code> NICKNAME mymessage will send the private message mymessage to the user NICKNAME.</li>
</ul>

<h3>Looking for more details on Screen?</h3>
<p>I guess I could share some...</p>
<p>None of these are really needed for just using IRC, but they can be nice if you are doing any other work on the server while wanting to stay connected to IRC.</p>
<p>All Screen keyboard commands are initiated by pressing Ctrl + A followed by another key.</p>

<ul class="collection">
	<li class="collection-item"><code>Ctrl</code> + <code>A</code> and then <code><strong>D</strong></code> Detaches from Screen.</li>
	<li class="collection-item"><code>Ctrl</code> + <code>A</code> and then <code><strong>C</strong></code> Creates a new Screen window.</li>
	<li class="collection-item"><code>Ctrl</code> + <code>A</code> and then <code><strong>N</strong></code> switches focus to the Next window in the Screen.</li>
	<li class="collection-item"><code>Ctrl</code> + <code>A</code> and then <code><strong>P</strong></code> switches focus to the Previous window in the Screen.</li>
	<li class="collection-item"><code>Ctrl</code> + <code>A</code> and then <code><strong>K</strong></code> Kills the current window in the Screen.</li>
</ul>

<p>For example, if I wanted to edit a text document while connected to IRC I would Create a new window (<code>Ctrl</code> + <code>A</code> and <code>C</code>), edit my doc in the new window with Vim, switch back and forth to keep chatting in Weechat with <code>Ctrl</code> + <code>A</code> and <code>N</code>/<code>P</code> and when I was done editing I would save the doc and Kill the window (<code>Ctrl</code> + <code>A</code> and <code>K</code>).</p>

@endsection