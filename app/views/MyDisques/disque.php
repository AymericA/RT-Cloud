        <div>
            <ul>
                <li class="list-group-item">
                    <div>
                        <span class="glyphicon glyphicon-hdd"></span> <b>{{nom}}</b>
                        <span class="badge">{{size}}/{{quota}}</span>
                    </div>

                    <br>

                    {% if occupation<=10 %}
                    <div class="progress">
                        <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="{{occupation}}" 
                             aria-valuemin="0" aria-valuemax="100" style="width:{{occupation}}%" >
                            {{occupation}}%
                        </div>
                    </div>

                    {% elseif occupation>10 and occupation<=50 %}
                    <div class="progress">
                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="{{occupation}}"
                            aria-valuemin="0" aria-valuemax="100" style="width:{{occupation}}%" >
                            {{occupation}}%
                        </div>
                    </div>
                    
                    {% elseif occupation>50 and occupation<=80 %}
                    <div class="progress">
                        <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="{{occupation}}" 
                             aria-valuemin="0" aria-valuemax="100" style="width:{{occupation}}%" >
                            {{occupation}}%
                        </div>
                    </div>
                    
                    {% elseif occupation>80 and occupation<=100 %}
                    <div class="progress">
                        <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="{{occupation}}" 
                             aria-valuemin="0" aria-valuemax="100" style="width:{{occupation}}%" >
                            {{occupation}}%
                        </div>
                    </div>
                    {% endif %}

                    
                    <a href="Scan/show/{{id}}">
                        <button type="button" class="btn btn-block btn-primary">
                            <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                            Ouvrir
                        </button>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
