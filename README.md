

# Domain-Driven Design (DDD)

## Общая идея проекта

Этот пример демонстрирует реализацию системы, основанной на подходе Domain-Driven Design (DDD), с разделением на домены — области бизнес-логики, и слоями инфраструктуры и приложения.

### Пример структуры проекта, основные классы и компоненты:

- PHP 8.1+
- Composer для управления зависимостями
- Doctrine ORM или аналог для работы с базой данных
- API-контроллер для взаимодействия через HTTP
- Redis для кэширования
- PHPUnit для тестирования
- Пример паттерна "Стратегия" для скидок


## 1. Модули и компоненты  (упрощенно)

### 1.1 Domain (Сущности, Value Objects, Бизнес-правила)

- **Order** — агрегат, содержит список OrderItem, управляет статусом и подсчётом суммы.
- **OrderItem** — значение, содержит товар, количество и цену.
- **Client** — значение, содержит сведения о клиенте.
- **Product** — значение, содержит сведения о товаре.
- **Money** — значение, инкапсулирует сумму и валюту.
- **OrderRepositoryInterface** — интерфейс репозитория.

### 1.2 Infrastructure (Реализация репозитория)

- **PDOOrderRepository** — реализует интерфейс, работает с базой данных через PDO.

### 1.3 API (Контроллеры)

- **OrderController** — принимает HTTP-запросы, вызывает бизнес-слой.

## Основной сценарий

Представим, что у нас есть система для управления заказами в интернет-магазине. Мы сфокусируемся на заказе (Order) как агрегате, который содержит позиции заказа (OrderItem) и связанные с ними бизнес-правила.

## Структура проекта (упрощенно)

```
src/
├── Domain/                     # Доменные модели и логика
│   ├── Entities/               # Сущности бизнес-логики
│   │   ├── Client.php
│   │   ├── Product.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   ├── ValueObjects/           # Значения-объекты
│   │   ├── UUID.php
│   │   ├── Price.php
│   ├── Aggregates/             # Агрегаты
│   │   ├── OrderAggregate.php
│   ├── Services/               # Доменные сервисы
│   │   ├── DiscountStrategy.php
│   │   ├── DiscountStrategyContext.php
│   ├── Exceptions/             # Исключения доменной области
│   │   ├── DomainException.php
│
├── Application/                # Использовательский слой (устройства, бизнес-логика)
│   ├── Commands/               # Команды
│   │   ├── CreateOrderCommand.php
│   ├── Handlers/               # Обработчики команд
│   │   ├── CreateOrderHandler.php
│   ├── Repositories/           # Репозитории интерфейсов
│   │   ├── OrderRepository.php
│   │   ├── ProductRepository.php
│   │   ├── ClientRepository.php
│   ├── Services/               # Услуги прикладного уровня (например, кеширование)
│       ├── CacheService.php
│
├── Infrastructure/             # Реализация инфраструктурных слоев
│   ├── Persistence/            # Реализация репозиториев (например, Doctrine)
│   │   ├── DoctrineOrderRepository.php
│   │   ├── DoctrineProductRepository.php
│   │   ├── DoctrineClientRepository.php
│   ├── Cache/                  # Реализация кеша
│   │   ├── RedisCache.php
│   ├── Database/               # Работа с базой данных (например, настройка EntityManager)
│   │   ├── EntityManagerFactory.php
│   ├── Http/                   # HTTP-сервис (например, запросы)
│       ├── Request.php
│
├── Http/                       # Веб-слой (контроллеры, роутеры)
│   ├── Controllers/
│       ├── OrderController.php
│
├── UI/                         # Пользовательский интерфейс (если есть)
│   ├── IRequest.php
│
tests/                          # Модуль для тестов (unit, функциональные)
└── ... (модули для тестов)
/config.php                     # Конфигурационный файл
/public                         # Веб-выходные файлы
  └── index.php                 # Точка входа
.htaccess                       # Конфигурация серверных правил
composer.json                   # Зависимости проекта
phpunit.xml                     # Конфигурация тестирования
```

## Итог

Этот пример показывает, как в PHP реализовать DDD:

- **Значения (Value Objects):** Money
- **Сущности, агрегаты:** Order, OrderItem, Client, Product
- **Репозитории:** интерфейс для хранения заказов
- **Бизнес-сервисы:** OrderService — реализует бизнес-логику
- **Redis:** для кэширования
- **Контроллер API:** — реализует взаимодействия через HTTP
- **PHPUnit:** — для тестирования

<br>
<br>
<br>



