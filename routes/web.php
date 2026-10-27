<?php

use App\Http\Controllers\AiDocumentQaController;
use App\Http\Controllers\AiKnowledgeSearchController;
use App\Http\Controllers\AiProductDescriptionController;
use App\Http\Controllers\TicketChatController;
use App\Http\Controllers\TicketDraftReplyStreamController;
use App\Http\Controllers\TicketTriageController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::livewire('tickets', 'pages::tickets.index')->name('tickets.index');
    Route::livewire('tickets/{ticket}', 'pages::tickets.show')->name('tickets.show');

    Route::post('tickets/{ticket}/ai/triage', TicketTriageController::class)
        ->name('tickets.ai.triage');

    Route::post('tickets/{ticket}/ai/chat', TicketChatController::class)
        ->name('tickets.ai.chat');

    Route::post('tickets/{ticket}/ai/draft-reply/stream', TicketDraftReplyStreamController::class)
        ->name('tickets.ai.draft-reply.stream');

    Route::get('ai/knowledge-search', AiKnowledgeSearchController::class)
        ->name('ai.knowledge-search');

    Route::get('ai/document-qa', [AiDocumentQaController::class, 'index'])
        ->name('ai.document-qa');

    Route::post('ai/document-qa/upload', [AiDocumentQaController::class, 'store'])
        ->name('ai.document-qa.upload');

    Route::post('ai/document-qa/ask', [AiDocumentQaController::class, 'ask'])
        ->name('ai.document-qa.ask');

    Route::delete('ai/document-qa/{uploadedDocument}', [AiDocumentQaController::class, 'destroy'])
        ->name('ai.document-qa.delete');

    Route::get('ai/product-description', [AiProductDescriptionController::class, 'index'])
        ->name('ai.product-description');

    Route::post('ai/product-description', [AiProductDescriptionController::class, 'store'])
        ->name('ai.product-description.store');
});

require __DIR__.'/settings.php';
