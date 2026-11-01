<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    public function getHeading(): string
    {
        return 'Ubah Data Pelanggan';
    }

    public function getSubheading(): ?string
    {
        return $this->record->name.' • '.$this->record->whatsapp;
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
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
