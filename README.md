# Recruiter Quiz ✨

### ❓ Quiz to test the general knowledge about programming languages. 

### ⚽ Contributions

#### Add question:

💡 For the sake of simplicity all questions are in a memory `App\Infrastructure\InMemory\InMemoryQuestionRepository::QUESTIONS`.

The only requirement to add a question is to update this constant with a new element structured like this:

```php
// Structure
[
    'id' => 'UUID V4', // can be generated at https://www.uuidgenerator.net/version4 
    'question' => 'Question content', // Should be in english
    'choices' => 'Array of available choices', // Multichoices is not supported yet
    'answer' => 'the key of the good answer in the choices array', 
    'link' => 'documentation or link to detail the good answer',
    'author' => 'your name',
    'author_link' => 'a link to your profile/blog...',
    'new' => true,
]
// Example
[
    'id' => 'b15a200c-8249-402f-a455-c4b4ef012236', 
    'question' => 'Java is an abbreviation for Javascript?',
    'choices' => ['True', 'False'],
    'answer' => 1,
    'link' => 'https://en.wikipedia.org/wiki/Java_(programming_language)',
    'author' => 'SmaineDev',
    'author_link' => 'https://twitter.com/SmaineDev',
    'new' => true,
]
```

#### Improve Code:

🔥 PR welcome if there is test.
