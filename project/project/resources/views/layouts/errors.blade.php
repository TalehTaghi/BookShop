@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('error_pass'))
    <div class="alert alert-danger">
        <p>Cari çifrə yanlış daxil edilmişdir!</p>
    </div>
@endif
@if(session('error_mail'))
    <div class="alert alert-danger">
        <p>Bu email artıq işlədilmişdir!</p>
    </div>
@endif
@if(session('error_phone'))
    <div class="alert alert-danger">
        <p>Bu nömrə artıq işlədilmişdir!</p>
    </div>
@endif
@if(session('error_same_category'))
    <div class="alert alert-danger">
        <p>Kateqoriya özü öz əsas kateqoriyası ola bilməz!</p>
    </div>
@endif
@if(session('error_deaktiv'))
    <div class="alert alert-danger">
        <p>Əsas kateqoriyası deaktiv olan kateqoriya aktivləşdirilə bilməz!</p>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        <p>Gözlənilməyən bir xəta baş verdi!</p>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success">
        <p>Əməliyyat uğurla icra edildi!</p>
    </div>
@endif
