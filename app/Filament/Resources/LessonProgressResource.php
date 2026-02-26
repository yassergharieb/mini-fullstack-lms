<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonProgressResource\Pages;
use App\Filament\Resources\LessonProgressResource\RelationManagers;
use App\Models\LessonProgress;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonProgressResource extends Resource
{
    protected static ?string $model = LessonProgress::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('lesson_id')
                    ->relationship('lesson', 'title')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\DateTimePicker::make('started_at')
                    ->required(),
                Forms\Components\DateTimePicker::make('completed_at'),
                Forms\Components\TextInput::make('watch_seconds')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lesson.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('started_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('completed')
                    ->label('Is Completed')
                    ->boolean()
                    ->state(fn ($record) => $record->completed_at !== null),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessonProgress::route('/'),
            'create' => Pages\CreateLessonProgress::route('/create'),
            'edit' => Pages\EditLessonProgress::route('/{record}/edit'),
        ];
    }
}
