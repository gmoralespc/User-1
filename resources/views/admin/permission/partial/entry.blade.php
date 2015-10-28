<div class='col-md-4 col-sm-6'>
               {!! Former::text('name')
               -> label(trans('user::permission.label.name'))
               -> placeholder(trans('user::permission.placeholder.name'))!!}
               </div>
                    <div class='col-md-4 col-sm-6'>
               {!! Former::text('readable_name')
               -> label(trans('user::permission.label.readable_name'))
               -> placeholder(trans('user::permission.placeholder.readable_name'))!!}
               </div>
          