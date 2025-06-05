<?php

namespace LaChaudiere\core\application\services;

use LaChaudiere\core\domain\entities\Event;
use LaChaudiereAgenda\core\application\exceptions\EventExceptions\GetEventByIdNotFoundException;
use Illuminate\Database\Eloquent\Collection;

class EventService
{
    private $eventRepository;

    /**
     * Constructeur du service
     *
     * @param \EventRepositoryInterface $eventRepository
     */
    public function __construct(\EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Récupère tous les événements
     *
     * @return Collection
     */
    public function getAllEvents(): Collection
    {
        return $this->eventRepository->getAll();
    }

    /**
     * Récupère un événement par son ID
     *
     * @param int $id
     * @return Event
     * @throws GetEventByIdNotFoundException si l'événement n'existe pas
     */
    public function getEventById(int $id): Event
    {
        $event = $this->eventRepository->getById($id);

        if (!$event) {
            throw new GetEventByIdNotFoundException($id);
        }

        return $event;
    }

    /**
     * Crée un nouvel événement
     *
     * @param array $data
     * @return Event
     */
    public function createEvent(array $data): Event
    {
        // Validation des données si nécessaire
        $this->validateEventData($data);

        return $this->eventRepository->create($data);
    }

    /**
     * Met à jour un événement existant
     *
     * @param int $id
     * @param array $data
     * @return Event
     * @throws GetEventByIdNotFoundException si l'événement n'existe pas
     */
    public function updateEvent(int $id, array $data): Event
    {
        // Validation des données si nécessaire
        $this->validateEventData($data);

        $event = $this->eventRepository->update($id, $data);

        if (!$event) {
            throw new GetEventByIdNotFoundException($id);
        }

        return $event;
    }

    /**
     * Supprime un événement
     *
     * @param int $id
     * @return bool
     * @throws GetEventByIdNotFoundException si l'événement n'existe pas
     */
    public function deleteEvent(int $id): bool
    {
        $result = $this->eventRepository->delete($id);

        if (!$result) {
            throw new GetEventByIdNotFoundException($id);
        }

        return true;
    }

    /**
     * Recherche des événements par catégorie
     *
     * @param int $categoryId
     * @return Collection
     */
    public function getEventsByCategory(int $categoryId): Collection
    {
        return Event::where('category_id', $categoryId)->get();
    }

    /**
     * Recherche des événements par créateur
     *
     * @param int $userId
     * @return Collection
     */
    public function getEventsByUser(int $userId): Collection
    {
        return Event::where('created_by', $userId)->get();
    }

    /**
     * Recherche des événements par période
     *
     * @param string $startDate
     * @param string $endDate
     * @return Collection
     */
    public function getEventsByDateRange(string $startDate, string $endDate): Collection
    {
        return Event::whereBetween('start_date', [$startDate, $endDate])
            ->orWhereBetween('end_date', [$startDate, $endDate])
            ->get();
    }

    /**
     * Valide les données d'un événement
     *
     * @param array $data
     * @return void
     * @throws \InvalidArgumentException si les données sont invalides
     */
    private function validateEventData(array $data): void
    {
        // Exemple de validation simple
        $requiredFields = ['title', 'description', 'start_date', 'category_id', 'created_by'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                throw new \InvalidArgumentException("Le champ '{$field}' est requis");
            }
        }

        // Validation de dates
        if (isset($data['start_date']) && isset($data['end_date'])) {
            $startDate = new \DateTime($data['start_date']);
            $endDate = new \DateTime($data['end_date']);

            if ($startDate > $endDate) {
                throw new \InvalidArgumentException("La date de début doit être antérieure à la date de fin");
            }
        }

        // Validation du prix (si présent)
        if (isset($data['price']) && !is_numeric($data['price'])) {
            throw new \InvalidArgumentException("Le prix doit être un nombre");
        }
    }
}