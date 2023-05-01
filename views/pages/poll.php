<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->
<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>-->
<!--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->
<!------ Include the above in your HEAD tag ---------->

<div class="container my-5" id="poll">
    <!--    anketa-->
    <div class="row d-flex justify-content-around align-items-center">
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title  blueLetters">
                        <span class="glyphicon glyphicon-arrow-right"></span>
                        How satisfied are you with the services on the site?
                        <span class="text-danger">*</span>
                    </h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group" id="radioDiv">
                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" class="optionsRadios" name="optionsRadios" value="5">
                                    Very good
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" class="optionsRadios" name="optionsRadios" value="4">
                                    Good
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" class="optionsRadios" name="optionsRadios" value="3">
                                    Okay
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" class="optionsRadios" name="optionsRadios" value="2">
                                    Bad
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" class="optionsRadios" name="optionsRadios" value="1">
                                    Very bad
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title  blueLetters">
                        <span class="glyphicon glyphicon-hand-right"></span>
                        How did you find out about this site?
                        <span class="text-danger text-sm">*</span>
                    </h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group" id="checkBoxDiv">
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="pollCheckGroup" value="friend">
                                    Over friend
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="pollCheckGroup" value="advertisements">
                                    Through advertisements
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="pollCheckGroup" value="social_media">
                                    Through social media
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="pollCheckGroup" value="artist">
                                    Through the artist
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="pollCheckGroup" value="other">
                                    Other
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!--    dugme -->
    <div class="text-light text-center mt-5" id="buttonDiv">
        <h2 class="blueLetters">Submit your answers</h2>
        <button type="button" class="btn btn-light mt-2" id="buttonPoll">
            Submit
        </button>
    </div>
</div>
<!--error blok-->
<div class="errorPoll mt-4 text-center">

</div>

