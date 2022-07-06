<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ URL::asset('../img/classroom.ico') }}" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />
    <style>
        #floatingbutton {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 99;
            font-size: 15px;
            border: none;
            background-color: #20DFDF;
            cursor: pointer;
            padding: 15px;
            border-radius: 50%;
            box-shadow: 2px 2px;
        }

        #floatingbutton:hover {
            background-color: #33F3FF;
        }

        #actions {
            display: none;
            position: absolute;
            right: 25px;
            bottom: 25px;
            background-color: darkcyan;
            color: white;
            min-width: 150px;
            box-shadow: 0px 5px 10px 0px rgba(0,0,0,2);
            z-index: 1;
        }

        #actions a {
            padding: 10px 12px;
            text-align: left;
            display: block;
        }

        #actions a:hover {
            background-color: #bdbdbd;
            color: black;
        }
    </style>
    <script>
        // Sidebar
        function open_sb() {
            document.getElementById("main").style.marginLeft = "25%";
            document.getElementById("sidebar").style.width = "25%";
            document.getElementById("sidebar").style.display = "block";
            document.getElementById("openNav").style.display = 'none';
        }
        function close_sb() {
            document.getElementById("main").style.marginLeft = "0%";
            document.getElementById("sidebar").style.display = "none";
            document.getElementById("openNav").style.display = "inline-block";
        }
    </script>
    <title>Subjects List | Tutor | MyTutor</title>
</head>

<body style="background: #E9FFFF">
    @if (session('save'))
    <script>
        alert("Success");
    </script> @endif
    @if (session('error'))
    <script>
        alert("Failed");
    </script> @endif
    
    <!-- Sidebar Menu -->
    <div class="w3-sidebar w3-bar-block w3-card-4 w3-animate-left" style="display:none" id="sidebar">
        <button class="w3-bar-item w3-button w3-large" onclick="close_sb()"><b>Close &times;</b></button><hr />
        <a href="{{ url('subjects-list') }}" class="w3-bar-item w3-button"><i class="fa fa-book"></i> Subjects</a>
        <a href="{{ route('logout') }}" class="w3-bar-item w3-button" onclick="return confirm('Are you sure?')"><i class="fa fa-sign-out"></i> Logout</a>
    </div>

    <div id="main">
        <div>
            <header class="header w3-card w3-center w3-padding-32">
            <button id="openNav" class="w3-button w3-xlarge w3-left" onclick="open_sb()">&#9776;</button>
                <div style="font-size: 225%; font-weight: bold"><i class="fa fa-graduation-cap"></i> MyTutor</div><br /><br />
                <div class="w3-bar w3-right" style="margin-right: 20px">
                    Welcome, <b>{{ Auth::guard('tutors')->user()->email }}</b>!
                </div>
            </header>
        </div>
        <div class="w3-container w3-padding-32" style="margin: 0 auto; padding-left: 64px; padding-right: 64px; word-wrap: keep-all">
            <h3>Subjects List</h3><hr />
            <table class='w3-table w3-striped w3-white w3-card'>
                <thead class="w3-cyan">
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price (RM)</th>
                    <th>Total Learning Hours</th>
                </thead>
                @if(empty($listSubjects))
                    <tr>
                        <td class="w3-center w3-padding-16 w3-text-red" colspan="5"><b>No Data</b></td>
                    </tr>
                @else
                    @foreach ($listSubjects as $sub)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $sub->subject_title }}</td>
                        <td>{{ $sub->subject_description }}</td>
                        <td>{{ $sub->subject_price }}</td>
                        <td>{{ $sub->subject_total_learning_hours }}</td>
                    </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>

    <!-- Add Subject Modal -->
    <div id="addsubject" class="w3-modal">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom">
            <header class="header w3-center w3-container w3-padding w3-large">
                <span onclick="document.getElementById('addsubject').style.display='none';" class="w3-button w3-display-topright">&times;</span>
                <p><b>New Subject</b></p>
            </header>
            <form name="add_subject" action="{{ route('add-subject') }}" method="post">
            {{csrf_field()}}
                <div class="w3-container w3-center w3-padding">
                    <!-- Title -->
                    <div class="w3-row w3-padding" style="display: flex; align-items: center; justify-content: center">
                        <div class="w3-col s1 m1 l1">
                            <i class="fa fa-book fa-lg"></i>
                        </div>
                        <span style="margin: 0 15px"></span>
                        <div class="w3-col s5 m6 l7">
                            <input class="w3-input w3-border w3-round" name="subtitle"  type="text" placeholder="Title" />
                        </div>
                    </div>
                    @if ($errors->has('subtitle'))
                    <span class="w3-red">{{ $errors->first('subtitle') }}</span><br />
                    @endif

                    <!-- Description -->
                    <div class="w3-row w3-padding" style="display: flex; align-items: center; justify-content: center">
                        <div class="w3-col s1 m1 l1">
                            <i class="fa fa-pencil-square-o fa-lg"></i>
                        </div>
                        <span style="margin: 0 15px"></span>
                        <div class="w3-col s5 m6 l7">
                            <textarea class="w3-input w3-border w3-round" rows="4" width="100%" name="subdesc" placeholder="Description"></textarea>
                        </div>
                    </div>
                    @if ($errors->has('subdesc'))
                    <span class="w3-red">{{ $errors->first('subdesc') }}</span><br />
                    @endif

                    <!-- Price -->
                    <div class="w3-row w3-padding" style="display: flex; align-items: center; justify-content: center">
                        <div class="w3-col s1 m1 l1">
                            <i class="fa fa-usd fa-lg"></i>
                        </div>
                        <span style="margin: 0 15px"></span>
                        <div class="w3-col s5 m6 l7">
                            <input class="w3-input w3-border w3-round" name="subprice" type="number" step="any" placeholder="Price (RM)" />
                        </div>
                    </div>
                    @if ($errors->has('subprice'))
                    <span class="w3-red">{{ $errors->first('subprice') }}</span><br />
                    @endif
                    
                    <!-- Total Learning Hours -->
                    <div class="w3-row w3-padding" style="display: flex; align-items: center; justify-content: center">
                        <div class="w3-col s1 m1 l1">
                            <i class="fa fa-clock-o fa-lg"></i>
                        </div>
                        <span style="margin: 0 15px"></span>
                        <div class="w3-col s5 m6 l7">
                            <input class="w3-input w3-border w3-round" name="subtlh" type="number" pattern="[0-9]" onkeypress="return !(event.charCode == 46)" placeholder="Total Learning Hours" />
                        </div>
                    </div>
                    @if ($errors->has('subtlh'))
                    <span class="w3-red">{{ $errors->first('subtlh') }}</span>
                    @endif

                    <div class="w3-padding-32">
                        <button class="w3-button w3-cyan w3-round w3-large" type="submit" name="add_sub">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer w3-center w3-padding" style="position: relative">&copy; MyTutor 2022</footer>

    <div id="floatingbutton" title="Actions" onmouseover="document.getElementById('actions').style.display='block';" onmouseleave="document.getElementById('actions').style.display='none';">
        <i class="fa fa-plus fa-lg"></i>
        <div id="actions" class="dropdown-content">
            <a onclick="document.getElementById('addsubject').style.display='block';"><i class="fa fa-pencil"></i> Add Subject</a>
            <a onclick=""><i class="fa fa-search"></i> Search</a>
        </div>
    </div>
</body>
</html>
