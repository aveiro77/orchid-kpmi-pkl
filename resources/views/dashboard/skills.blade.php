<div class="bg-white p-4 rounded shadow-sm">
    <h3 class="mb-3">Skill dan Peran</h3>
    @if(isset($skills) && is_array($skills))
        @foreach($skills as $skill)
            <span class="badge bg-primary text-white me-1">{{ $skill }}</span>
        @endforeach
    @else
        <p>Tidak ada skill atau peran yang tercatat.</p>
    @endif
</div>
