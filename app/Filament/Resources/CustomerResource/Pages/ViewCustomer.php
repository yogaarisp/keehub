<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomer extends ViewRecord
{
    protected static string $resource = CustomerResource::class;

    public function getHeading(): string
    {
        return $this->record->name;
    }

    public function getSubheading(): ?string
    {
        return 'Pelanggan • '.$this->record->whatsapp.($this->record->email ? ' • '.$this->record->email : '');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('chat_wa')
                ->label('Chat WhatsApp')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->color('success')
                ->url(
                    fn (): string => 'https://wa.me/'.CustomerResource::formatWaNumber($this->record->whatsapp),
                    shouldOpenInNewTab: true
                ),
            Actions\EditAction::make(),
        ];
    }
}
