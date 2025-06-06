<?php

namespace LaChaudiere\core\application\UseCase\Event;

use LaChaudiere\core\application\exceptions\ApplicationException;
use LaChaudiere\core\application\exceptions\CategoryExceptions\GetCategoryByIdNotFoundException;
use LaChaudiere\core\application\exceptions\EventExceptions\CreateEventFailedException;
use LaChaudiere\core\application\interfaces\EventRepositoryInterface;
use LaChaudiere\core\application\interfaces\CategoryRepositoryInterface;
use LaChaudiere\core\application\interfaces\UserRepositoryInterface;
use LaChaudiere\core\domain\entities\Event;
use LaChaudiere\core\domain\entities\User;

class CreateEvent
{
    private EventRepositoryInterface $eventRepository;
    private CategoryRepositoryInterface $categoryRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        EventRepositoryInterface $eventRepository,
        CategoryRepositoryInterface $categoryRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->eventRepository = $eventRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(array $data): Event
    {
        if (!isset($data['title'], $data['category_id'], $data['created_by'])) {
            throw new CreateEventFailedException();
        }

        if (!$this->categoryRepository->findById($data['category_id'])) {
            throw new GetCategoryByIdNotFoundException($data['category_id']);
        }

        if (!User::find($data['created_by'])) {
            throw new ApplicationException($data['created_by']);
        }
        if (!$this->userRepository->findById($data['created_by'])) {
            throw new ApplicationException($data['created_by']);
        }

        return $this->eventRepository->create($data);
    }
}
