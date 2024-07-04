<div class="form-group row align-items-center" :class="{'has-danger': errors.has('nombre'), 'has-success': fields.nombre && fields.nombre.valid }">
    <label for="nombre" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.nombre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.nombre" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('nombre'), 'form-control-success': fields.nombre && fields.nombre.valid}" id="nombre" name="nombre" placeholder="{{ trans('admin.user.columns.nombre') }}">
        <div v-if="errors.has('nombre')" class="invalid-feedback" v-cloak>@{{ errors.first('nombre') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('email'), 'has-success': fields.email && fields.email.valid }">
    <label for="email" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.email') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="email" v-model="form.email" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('email'), 'form-control-success': fields.email && fields.email.valid}" id="email" name="email" placeholder="{{ trans('admin.user.columns.email') }}">
        <div v-if="errors.has('email')" class="invalid-feedback" v-cloak>@{{ errors.first('email') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('contraseña'), 'has-success': fields.contraseña && fields.contraseña.valid }">
    <label for="contraseña" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user.columns.contraseña') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="password" v-model="form.contraseña" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('contraseña'), 'form-control-success': fields.contraseña && fields.contraseña.valid}" id="contraseña" name="contraseña" placeholder="{{ trans('admin.user.columns.contraseña') }}">
        <div v-if="errors.has('contraseña')" class="invalid-feedback" v-cloak>@{{ errors.first('contraseña') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('contraseña_confirmation'), 'has-success': fields.contraseña_confirmation && fields.contraseña_confirmation.valid }">
    <label for="contraseña_confirmation" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('Confirmar Contraseña') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="password" v-model="form.contraseña_confirmation" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('contraseña_confirmation'), 'form-control-success': fields.contraseña_confirmation && fields.contraseña_confirmation.valid}" id="contraseña_confirmation" name="contraseña_confirmation" placeholder="{{ trans('Confirmar Contraseña') }}">
        <div v-if="errors.has('contraseña_confirmation')" class="invalid-feedback" v-cloak>@{{ errors.first('contraseña_confirmation') }}</div>
    </div>
</div>
