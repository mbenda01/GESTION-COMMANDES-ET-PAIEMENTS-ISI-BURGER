@extends('layouts.superadmin')

@section('content')

{{-- KPI --}}
@php
    $totalUsers         = \App\Models\User::count();
    $totalGestionnaires = \App\Models\User::role('Gestionnaire')->count();
    $totalClients       = \App\Models\User::role('Client')->count();
@endphp

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px;">
    @foreach([
        ['icon'=>'bi-people-fill','bg'=>'#e8f0fe','color'=>'#0d6efd','val'=>$totalUsers,       'lbl'=>'Total utilisateurs'],
        ['icon'=>'bi-shield-fill', 'bg'=>'#fff8e1','color'=>'#f59e0b','val'=>$totalGestionnaires,'lbl'=>'Gestionnaires'],
        ['icon'=>'bi-person-fill', 'bg'=>'#dcfce7','color'=>'#16a34a','val'=>$totalClients,     'lbl'=>'Clients'],
    ] as $kpi)
    <div style="background:white;border-radius:14px;padding:16px 20px;border:1.5px solid #f3f4f6;box-shadow:0 2px 8px rgba(0,0,0,0.05);display:flex;align-items:center;gap:14px;">
        <div style="width:44px;height:44px;border-radius:12px;background:{{ $kpi['bg'] }};color:{{ $kpi['color'] }};display:flex;align-items:center;justify-content:center;font-size:1.2rem;">
            <i class="bi {{ $kpi['icon'] }}"></i>
        </div>
        <div>
            <span style="font-size:1.4rem;font-weight:800;color:#111827;display:block;line-height:1;">{{ $kpi['val'] }}</span>
            <span style="font-size:0.72rem;color:#9ca3af;font-weight:600;">{{ $kpi['lbl'] }}</span>
        </div>
    </div>
    @endforeach
</div>

<div class="page-header-isi">
    <div>
        <h2 class="page-title-isi"><i class="bi bi-people-fill"></i> Gestion des utilisateurs</h2>
        <p class="page-subtitle-isi">{{ $users->total() }} utilisateur(s) au total</p>
    </div>
    <a href="{{ route('superadmin.users.create') }}" class="btn-isi-yellow">
        <i class="bi bi-plus-lg"></i> Ajouter un utilisateur
    </a>
</div>

@forelse($users as $i => $user)
<div style="background:white;border-radius:14px;border:1.5px solid #f3f4f6;box-shadow:0 2px 8px rgba(0,0,0,0.05);padding:16px 20px;margin-bottom:10px;display:flex;align-items:center;gap:16px;transition:all 0.25s;animation:fadeInUp 0.35s ease both;" onmouseover="this.style.borderColor='#ffc107'" onmouseout="this.style.borderColor='#f3f4f6'">

    {{-- Avatar --}}
    <div style="width:44px;height:44px;border-radius:12px;background:{{ $user->hasRole('Gestionnaire') ? 'linear-gradient(135deg,#ffc107,#f59e0b)' : 'linear-gradient(135deg,#0a2a6e,#0d3a9e)' }};color:{{ $user->hasRole('Gestionnaire') ? '#0a2a6e' : 'white' }};display:flex;align-items:center;justify-content:center;font-size:0.85rem;font-weight:800;flex-shrink:0;">
        {{ strtoupper(substr($user->name, 0, 1)) }}
    </div>

    {{-- Infos --}}
    <div style="flex:1;">
        <div style="font-size:0.9rem;font-weight:800;color:#0a2a6e;">{{ $user->name }}</div>
        <div style="font-size:0.78rem;color:#9ca3af;">{{ $user->email }}</div>
    </div>

    {{-- Role badge --}}
    @if($user->hasRole('Administrateur'))
        <span style="background:#f3e8ff;color:#7c3aed;padding:4px 12px;border-radius:999px;font-size:0.72rem;font-weight:800;display:inline-flex;align-items:center;gap:5px;">
            <i class="bi bi-lock-fill"></i> Administrateur
        </span>
    @elseif($user->hasRole('Gestionnaire'))
        <span style="background:#fff8e1;color:#f59e0b;padding:4px 12px;border-radius:999px;font-size:0.72rem;font-weight:800;display:inline-flex;align-items:center;gap:5px;">
            <i class="bi bi-shield-fill"></i> Gestionnaire
        </span>
    @else
        <span style="background:#e8f0fe;color:#0d6efd;padding:4px 12px;border-radius:999px;font-size:0.72rem;font-weight:800;display:inline-flex;align-items:center;gap:5px;">
            <i class="bi bi-person-fill"></i> Client
        </span>
    @endif

    {{-- Date --}}
    <div style="font-size:0.78rem;color:#9ca3af;">
        <i class="bi bi-calendar3 me-1"></i>
        {{ $user->created_at->format('d/m/Y') }}
    </div>

    {{-- Actions --}}
    @if(!$user->hasRole('Administrateur'))
    <div style="display:flex;gap:6px;">
        <a href="{{ route('superadmin.users.edit', $user) }}"
           style="background:#e8f0fe;color:#0d6efd;border:none;border-radius:9px;padding:7px 12px;font-size:0.75rem;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
            <i class="bi bi-pencil-fill"></i> Modifier
        </a>
        <form method="POST" action="{{ route('superadmin.users.destroy', $user) }}"
              onsubmit="return confirm('Supprimer {{ $user->name }} ?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    style="background:#fee2e2;color:#dc2626;border:none;border-radius:9px;padding:7px 12px;font-size:0.75rem;font-weight:800;cursor:pointer;">
                <i class="bi bi-trash-fill"></i>
            </button>
        </form>
    </div>
    @endif
</div>
@empty
<div style="text-align:center;padding:60px 20px;color:#9ca3af;">
    <i class="bi bi-people" style="font-size:3rem;display:block;margin-bottom:16px;"></i>
    <h3 style="font-size:1.1rem;font-weight:800;">Aucun utilisateur</h3>
</div>
@endforelse

{{-- Pagination --}}
@if($users->hasPages())
<nav class="mt-4" style="display:flex;justify-content:center;gap:6px;">
    @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
        <a href="{{ $url }}"
           style="width:38px;height:38px;border-radius:10px;border:2px solid {{ $users->currentPage() == $page ? '#0a2a6e' : '#e5e7eb' }};background:{{ $users->currentPage() == $page ? '#0a2a6e' : 'white' }};color:{{ $users->currentPage() == $page ? 'white' : '#374151' }};display:flex;align-items:center;justify-content:center;text-decoration:none;font-weight:700;font-size:0.875rem;">
            {{ $page }}
        </a>
    @endforeach
</nav>
@endif

@endsection
