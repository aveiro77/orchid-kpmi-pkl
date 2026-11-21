<?php

namespace App\Orchid\Screens\Opportunity;

use App\Models\Opportunity;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Actions\Link;
use Illuminate\Support\Facades\Gate;

class OpportunityDetailScreen extends Screen
{
    public $opportunity;

    public function query(Opportunity $opportunity): iterable
    {
        $opportunity->load('member');

        if (! Gate::allows('view', $opportunity)) {
            abort(403);
        }

        return [
            'opportunity' => $opportunity,
        ];
    }

    public function name(): ?string
    {
        return 'Detail Peluang: ' . $this->opportunity->judul;
    }

    public function commandBar(): iterable
    {
        $waUrl = $this->getWhatsAppUrl();

        $actions = [
            Link::make('Kembali ke Papan')
                ->icon('bs.arrow-left')
                ->route('platform.opportunity-board'),
        ];

        if ($waUrl) {
            $actions[] = Link::make('Hubungi via WhatsApp')
                ->icon('bs.whatsapp')
                ->href($waUrl)
                ->target('_blank')
                ->class('btn btn-success');
        }

        return $actions;
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('opportunity.judul')
                    ->title('Judul Peluang')
                    ->readonly(),

                Input::make('opportunity.tipe')
                    ->title('Tipe')
                    ->value(ucfirst($this->opportunity->tipe))
                    ->readonly(),

                Input::make('opportunity.member.nama_lengkap')
                    ->title('Pemilik / Anggota')
                    ->readonly(),

                Input::make('opportunity.lokasi')
                    ->title('Lokasi')
                    ->readonly(),

                Input::make('opportunity.tanggal_expired')
                    ->title('Berlaku Hingga')
                    ->value($this->opportunity->tanggal_expired?->format('d M Y'))
                    ->readonly(),

                TextArea::make('opportunity.deskripsi')
                    ->title('Deskripsi Lengkap')
                    ->rows(6)
                    ->readonly(),
            ])
        ];
    }

    private function getWhatsAppUrl(): ?string
    {
        $phone = $this->opportunity->member?->nomor_wa;
        if (empty($phone)) {
            return null;
        }

        // Normalisasi nomor: buang karakter non-angka
        $cleaned = preg_replace('/\D+/', '', $phone);

        // Ganti awalan 0 menjadi 62
        if (str_starts_with($cleaned, '0')) {
            $cleaned = '62' . substr($cleaned, 1);
        }

        return 'https://wa.me/' . $cleaned;
    }
}
